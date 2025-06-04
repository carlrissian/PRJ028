<?php

namespace Distribution\Route\Application\ProcessFileRoute;

use SplFileInfo;
use Shared\Domain\Criteria\Filter;
use Distribution\Route\Domain\Route;
use Distribution\Branch\Domain\Branch;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\Route\Domain\RouteCriteria;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Route\Domain\RouteRepository;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Branch\Domain\BranchCollection;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Route\Domain\RouteExcelConstants;
use Distribution\Route\Domain\RouteExcelException;
use Distribution\Supplier\Domain\SupplierCriteria;
use Distribution\Route\Domain\Branch as RouteBranch;
use Distribution\Supplier\Domain\SupplierCollection;
use Distribution\Supplier\Domain\SupplierRepository;
use Distribution\Route\Domain\Supplier as RouteSupplier;
use Distribution\TransportMethod\Domain\TransportMethodCriteria;
use Distribution\TransportMethod\Domain\TransportMethodCollection;
use Distribution\TransportMethod\Domain\TransportMethodRepository;
use Distribution\Route\Domain\TransportMethod as RouteTransportMethod;

class ProcessFileRouteCommandHandler
{
    /**
     * @var RouteRepository
     */
    private RouteRepository $routeRepository;

    /**
     * @var TransportMethodRepository
     */
    private TransportMethodRepository $transportMethodRepository;

    /**
     * @var SupplierRepository
     */
    private SupplierRepository $supplierRepository;

    /**
     * @var BranchRepository
     */
    private BranchRepository $branchRepository;

    /**
     * @var TransportMethodCollection|null
     */
    private $transportMethodCollection;

    /**
     * @var SupplierCollection|null
     */
    private $supplierCollection;

    /**
     * @var BranchCollection|null
     */
    private $branchCollection;

    /**
     * @var array
     */
    private array $headers;

    /**
     * @var array
     */
    private array $errors;

    /**
     * @var array|null
     */
    private ?array $routesExcel;

    /**
     * @var array|null
     */
    private ?array $managedRoutes;

    /**
     * @param RouteRepository $routeRepository
     * @param TransportMethodRepository $transportMethodRepository
     * @param SupplierRepository $supplierRepository
     * @param BranchRepository $branchRepository
     */
    public function __construct(
        RouteRepository $routeRepository,
        TransportMethodRepository $transportMethodRepository,
        SupplierRepository $supplierRepository,
        BranchRepository $branchRepository
    ) {
        $this->routeRepository = $routeRepository;
        $this->transportMethodRepository = $transportMethodRepository;
        $this->supplierRepository = $supplierRepository;
        $this->branchRepository = $branchRepository;

        $this->headers = RouteExcelConstants::toArray();
        $this->errors = [];
        $this->managedRoutes = [
            "created" => [],
            "updated" => [],
            "deleted" => [],
        ];
    }

    /**
     * @param ProcessFileRouteQuery $command
     * @return ProcessFileRouteResponse
     * 
     * @throws RouteExcelException
     */
    final public function handle(ProcessFileRouteCommand $command): ProcessFileRouteResponse
    {
        $this->routesExcel = $this->checkExcelFile($command->getFile());

        if (empty($this->errors)) {
            $this->verifyRoutes();
        }

        if (empty($this->errors)) {
            $this->manageRoutes();
        }

        if (!empty($this->errors)) {
            throw new RouteExcelException('', $this->errors);
        }

        return new ProcessFileRouteResponse(true, 'Gestión de rutas realizada correctamente.', $this->managedRoutes);
    }

    /**
     * Comprobación de los datos introducidos en el archivo excel
     *
     * @param SplFileInfo $file
     * @return array
     */
    private function checkExcelFile(SplFileInfo $file): array
    {
        $countHeaders = 0;
        $headers = [];
        $routesData = [];

        $fp = fopen($file->getRealPath(), 'rb');

        while ($row = fgetcsv($fp, 1000, ';')) {
            if ($countHeaders === 0) {
                $headers = $this->checkHeaders($row);
                if (count($headers) === 0 || count($this->errors) > 0) {
                    break;
                }
            } else {
                $body = $this->checkBody($row, $headers, $countHeaders);

                if (count($body) === 0) {
                    break;
                }

                $routesData[] = $body;
            }

            $countHeaders++;
        }

        fclose($fp);

        if ($countHeaders == 1) {
            $this->errors[] = "No se han introducido datos de rutas.";
        }
        if (count($headers) === 0) {
            $this->errors[] = 'El archivo excel (CSV) no puede estar vacío.';
        }

        return $routesData;
    }

    private function checkHeaders(array $headers)
    {
        $finalHeaders = [];

        // Primero eliminamos caracreteres especiales y comillas
        $headers = array_map(function ($value) {
            return str_replace("\"", '', str_replace("\xEF\xBB\xBF", '', $value));
        }, $headers);

        // Luego filtramos campos vacíos y nulos. Si no se hace así, array_filter devuelve un array con un string vacío.
        $headers = array_filter($headers, function ($value) {
            return $value !== "" && !is_null($value);
        });

        foreach ($headers as $position => $headerName) {
            if (!in_array($headerName, $this->headers, true)) {
                $this->errors[] = "La columna '$headerName' no es correcta";
            } else if (array_search($headerName, $this->headers, true) !== $position) {
                $this->errors[] = "La columna '$headerName' no se puede cambiar de posición";
            }

            $finalHeaders[] = RouteExcelConstants::getHeader($headerName);
        }

        $requiredHeaders = [
            RouteExcelConstants::TITLE_TRANSPORT_METHOD,
            RouteExcelConstants::TITLE_PROVIDERID,
            RouteExcelConstants::TITLE_ORIGIN_BRANCH,
            RouteExcelConstants::TITLE_DESTINATION_BRANCH,
        ];

        foreach ($requiredHeaders as $field) {
            if (!in_array($field, $headers, true)) {
                $this->errors[] = sprintf('Las siguientes columnas son obligatorias: %s', implode(', ', array_map(function ($header) {
                    return "'$header'";
                }, $requiredHeaders)));
                break;
            }
        }

        return $finalHeaders;
    }

    private function checkBody($row, $headers, $countHeaders): array
    {
        $dataColumn = [];
        foreach ($headers as $key => $head) {
            if ($row[$key] !== '') {
                $dataColumn[$head] = trim($row[$key]);
            }
        }

        // Método de transporte
        if (!array_key_exists(RouteExcelConstants::TRANSPORT_METHOD, $dataColumn)) {
            $this->errors[] = sprintf('Debes insertar el %s de la ruta en la fila %d.', strtolower(RouteExcelConstants::TITLE_TRANSPORT_METHOD), ($countHeaders + 1));
        }

        // Proveedor
        if (!array_key_exists(RouteExcelConstants::PROVIDERID, $dataColumn)) {
            $this->errors[] = sprintf('Debes insertar el %s de la ruta en la fila %d.', strtolower(RouteExcelConstants::TITLE_PROVIDERID), ($countHeaders + 1));
        } else if (!is_numeric($dataColumn[RouteExcelConstants::PROVIDERID])) {
            $this->errors[] = sprintf("El %s '%s' en la fila %d no es un número correcto.", strtolower(RouteExcelConstants::TITLE_PROVIDERID), $dataColumn[RouteExcelConstants::PROVIDERID], ($countHeaders + 1));
        }

        // Origen
        if (!array_key_exists(RouteExcelConstants::ORIGIN_BRANCH, $dataColumn)) {
            $this->errors[] = sprintf('Debes insertar el %s de la ruta en la fila %d.', strtolower(RouteExcelConstants::ORIGIN_BRANCH), ($countHeaders + 1));
        }

        // Destino
        if (!array_key_exists(RouteExcelConstants::DESTINATION_BRANCH, $dataColumn)) {
            $this->errors[] = sprintf('Debes insertar el %s de la ruta en la fila %d.', strtolower(RouteExcelConstants::DESTINATION_BRANCH), ($countHeaders + 1));
        }


        foreach ($dataColumn as $column => $value) {
            switch ($column) {
                case RouteExcelConstants::AMOUNT_FULL_TRUCK:
                case RouteExcelConstants::AMOUNT_VEHICLE_1:
                case RouteExcelConstants::AMOUNT_VEHICLE_2:
                case RouteExcelConstants::AMOUNT_VEHICLE_3:
                case RouteExcelConstants::AMOUNT_VEHICLE_4:
                case RouteExcelConstants::AMOUNT_VEHICLE_5:
                case RouteExcelConstants::AMOUNT_VEHICLE_6:
                case RouteExcelConstants::AMOUNT_VEHICLE_7:
                case RouteExcelConstants::AMOUNT_VEHICLE_8:
                case RouteExcelConstants::AMOUNT_VEHICLE_9:
                case RouteExcelConstants::AMOUNT_VEHICLE_10:
                case RouteExcelConstants::AMOUNT_SUV:
                case RouteExcelConstants::AMOUNT_VAN:
                    $dataColumn[$column] = $this->verifyFloatValid($column, $value);
                    break;
            }
        }

        return $dataColumn;
    }

    private function verifyRoutes(): void
    {
        $this->transportMethodCollection = $this->transportMethodRepository->getBy(new TransportMethodCriteria())->getCollection();
        $this->supplierCollection = $this->supplierRepository->getBy(new SupplierCriteria())->getCollection();
        $this->branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();

        // Datos de ruta
        foreach ($this->routesExcel as $position => $routeData) {
            // Comprobación de método de transporte
            if (isset($routeData[RouteExcelConstants::TRANSPORT_METHOD])) {
                try {
                    $transportMethod = (is_numeric($routeData[RouteExcelConstants::TRANSPORT_METHOD])) ?
                        $this->transportMethodCollection->getByProperty(intval($routeData[RouteExcelConstants::TRANSPORT_METHOD]), 'id')
                        : $this->transportMethodCollection->getByProperty(strtoupper($routeData[RouteExcelConstants::TRANSPORT_METHOD]), 'name');
                    // $this->routesExcel[$position][RouteExcelConstants::TRANSPORT_METHOD] = $transportMethod;
                } catch (\Exception $e) {
                    $this->errors[] = sprintf("El %s con ID/nombre '%s' no existe en el sístema.", strtolower(RouteExcelConstants::TITLE_TRANSPORT_METHOD), $routeData[RouteExcelConstants::TRANSPORT_METHOD]);
                }
            }

            // Comprobación de proveedor
            if (isset($routeData[RouteExcelConstants::PROVIDERID])) {
                try {
                    $supplier = $this->supplierCollection->getByProperty(intval($routeData[RouteExcelConstants::PROVIDERID]), 'id');
                    // $this->routesExcel[$position][RouteExcelConstants::PROVIDERID] = $supplier;
                } catch (\Exception $e) {
                    $this->errors[] = sprintf("El %s '%s' no existe en el sístema.", strtolower(RouteExcelConstants::TITLE_PROVIDERID), $routeData[RouteExcelConstants::PROVIDERID]);
                }
            }

            // Comprobación de delegaciones
            [$originBranch, $destinationBranch] = null;
            if (isset($routeData[RouteExcelConstants::ORIGIN_BRANCH])) {
                $originBranch = (is_numeric($routeData[RouteExcelConstants::ORIGIN_BRANCH])) ?
                    $this->checkBranch(intval($routeData[RouteExcelConstants::ORIGIN_BRANCH]), 'id', strtolower(RouteExcelConstants::TITLE_ORIGIN_BRANCH))
                    : $this->checkBranch($routeData[RouteExcelConstants::ORIGIN_BRANCH], 'branchIATA', strtolower(RouteExcelConstants::TITLE_ORIGIN_BRANCH));
                // $this->routesExcel[$position][RouteExcelConstants::ORIGIN_BRANCH] = $originBranch;
            }
            if (isset($routeData[RouteExcelConstants::DESTINATION_BRANCH])) {
                $destinationBranch = (is_numeric($routeData[RouteExcelConstants::DESTINATION_BRANCH])) ?
                    $this->checkBranch(intval($routeData[RouteExcelConstants::DESTINATION_BRANCH]), 'id', strtolower(RouteExcelConstants::TITLE_DESTINATION_BRANCH))
                    : $this->checkBranch($routeData[RouteExcelConstants::DESTINATION_BRANCH], 'branchIATA', strtolower(RouteExcelConstants::TITLE_DESTINATION_BRANCH));
                // $this->routesExcel[$position][RouteExcelConstants::DESTINATION_BRANCH] = $destinationBranch;
            }
            if (($originBranch !== null && $destinationBranch !== null) && $originBranch === $destinationBranch) {
                $this->errors[] = sprintf("La %s y %s no pueden ser iguales (ID/IATA: '%s').", strtolower(RouteExcelConstants::TITLE_ORIGIN_BRANCH), strtolower(RouteExcelConstants::TITLE_DESTINATION_BRANCH), $routeData[RouteExcelConstants::ORIGIN_BRANCH]);
            }
        }
    }

    private function manageRoutes(): void
    {
        foreach ($this->routesExcel as $routeData) {
            $requiredData = array_slice($routeData, 0, 4, true);
            $notRequiredData = array_slice($routeData, 4, 13, true);

            if (!in_array('', $requiredData)) {
                $transportMethodId = (is_numeric($routeData[RouteExcelConstants::TRANSPORT_METHOD])) ?
                    $this->transportMethodCollection->getByProperty(intval($routeData[RouteExcelConstants::TRANSPORT_METHOD]), 'id')->getId()
                    : $this->transportMethodCollection->getByProperty(strtoupper($routeData[RouteExcelConstants::TRANSPORT_METHOD]), 'name')->getId();

                $providerId = $this->supplierCollection->getByProperty(intval($routeData[RouteExcelConstants::PROVIDERID]), 'id')->getId();

                $originBranchId = (is_numeric($routeData[RouteExcelConstants::ORIGIN_BRANCH])) ?
                    $this->checkBranch(intval($routeData[RouteExcelConstants::ORIGIN_BRANCH]), 'id', strtolower(RouteExcelConstants::TITLE_ORIGIN_BRANCH))->getId()
                    : $this->checkBranch($routeData[RouteExcelConstants::ORIGIN_BRANCH], 'branchIATA', strtolower(RouteExcelConstants::TITLE_ORIGIN_BRANCH))->getId();

                $destinationBranchId = (is_numeric($routeData[RouteExcelConstants::DESTINATION_BRANCH])) ?
                    $this->checkBranch(intval($routeData[RouteExcelConstants::DESTINATION_BRANCH]), 'id', strtolower(RouteExcelConstants::TITLE_DESTINATION_BRANCH))->getId()
                    : $this->checkBranch($routeData[RouteExcelConstants::DESTINATION_BRANCH], 'branchIATA', strtolower(RouteExcelConstants::TITLE_DESTINATION_BRANCH))->getId();


                $filterCollection = new FilterCollection([]);
                $filterCollection->add(new Filter('TRANSPORTMETHODID', new FilterOperator(FilterOperator::EQUAL), $transportMethodId));
                $filterCollection->add(new Filter('TRANSPORTPROVIDERID', new FilterOperator(FilterOperator::EQUAL), $providerId));
                $filterCollection->add(new Filter('BRANCHORIGINID', new FilterOperator(FilterOperator::EQUAL), $originBranchId));
                $filterCollection->add(new Filter('BRANCHDESTINYID', new FilterOperator(FilterOperator::EQUAL), $destinationBranchId));

                try {
                    $routeGetByResponse = $this->routeRepository->getBy(new RouteCriteria($filterCollection));
                } catch (\Exception $e) {
                    $this->errors[] = "Se ha producido un error durante la obtención de rutas existentes en el sistema.";
                    throw new RouteExcelException('', $this->errors, Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                // Si existe la ruta en el sistema, se actualiza o se borra
                if ($routeGetByResponse->getTotalRows() > 0) {
                    $route = $routeGetByResponse->getCollection()[0];

                    // Si no hay importes, se borra la ruta
                    if (count(array_filter($notRequiredData, function ($amount) {
                        return $amount == "" || empty($amount);
                    })) === count($notRequiredData)) {
                        // FIXME response una vez eliminado: "{"SUCESS":null}"
                        try {
                            $deleted = $this->routeRepository->delete($route->getId());
                            if ($deleted) array_push($this->managedRoutes['deleted'], $route->getId());
                        } catch (\Exception $e) {
                            $this->appendDivider();
                            $this->errors[] =
                                "Se ha producido un error durante la eliminación de la ruta:
                                <ul>
                                    <li>" . RouteExcelConstants::TITLE_TRANSPORT_METHOD . ": '{$routeData[RouteExcelConstants::TRANSPORT_METHOD]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_PROVIDERID . ": '{$routeData[RouteExcelConstants::PROVIDERID]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_ORIGIN_BRANCH . ": '{$routeData[RouteExcelConstants::ORIGIN_BRANCH]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_DESTINATION_BRANCH . ": '{$routeData[RouteExcelConstants::DESTINATION_BRANCH]}'.</li>
                                </ul>
                            ";
                        }
                    } else {
                        // Se actualiza la ruta
                        $route->setFullTruckLoadAmount(isset($routeData[RouteExcelConstants::AMOUNT_FULL_TRUCK]) ? $routeData[RouteExcelConstants::AMOUNT_FULL_TRUCK] : 0);
                        $route->setVehicleAmount1(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_1]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_1] : 0);
                        $route->setVehicleAmount2(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_2]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_2] : 0);
                        $route->setVehicleAmount3(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_3]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_3] : 0);
                        $route->setVehicleAmount4(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_4]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_4] : 0);
                        $route->setVehicleAmount5(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_5]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_5] : 0);
                        $route->setVehicleAmount6(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_6]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_6] : 0);
                        $route->setVehicleAmount7(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_7]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_7] : 0);
                        $route->setVehicleAmount8(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_8]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_8] : 0);
                        $route->setVehicleAmount9(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_9]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_9] : 0);
                        $route->setVehicleAmount10(isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_10]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_10] : 0);
                        $route->setSuvLoadAmount(isset($routeData[RouteExcelConstants::AMOUNT_SUV]) ? $routeData[RouteExcelConstants::AMOUNT_SUV] : 0);
                        $route->setVanLoadAmount(isset($routeData[RouteExcelConstants::AMOUNT_VAN]) ? $routeData[RouteExcelConstants::AMOUNT_VAN] : 0);

                        try {
                            $updatedRouteId = $this->routeRepository->update($route);
                            if ($updatedRouteId) array_push($this->managedRoutes['updated'], $updatedRouteId);
                        } catch (\Exception $e) {
                            $this->appendDivider();
                            $this->errors[] =
                                "Error en la actualización de la ruta:
                                <ul>
                                    <li>" . RouteExcelConstants::TITLE_TRANSPORT_METHOD . ": '{$routeData[RouteExcelConstants::TRANSPORT_METHOD]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_PROVIDERID . ": '{$routeData[RouteExcelConstants::PROVIDERID]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_ORIGIN_BRANCH . ": '{$routeData[RouteExcelConstants::ORIGIN_BRANCH]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_DESTINATION_BRANCH . ": '{$routeData[RouteExcelConstants::DESTINATION_BRANCH]}'.</li>
                                </ul>
                            ";
                        }
                    }
                } else {
                    // Si no hay importes, se iunforma
                    if (count(array_filter($notRequiredData, function ($amount) {
                        return $amount == "" || empty($amount);
                    })) === count($notRequiredData)) {
                        $this->appendDivider();
                        $this->errors[] =
                            "Error en la creación de ruta. No se ha insertado importes para la ruta:
                            <ul>
                                <li>" . RouteExcelConstants::TITLE_TRANSPORT_METHOD . ": '{$routeData[RouteExcelConstants::TRANSPORT_METHOD]}'.</li>
                                <li>" . RouteExcelConstants::TITLE_PROVIDERID . ": '{$routeData[RouteExcelConstants::PROVIDERID]}'.</li>
                                <li>" . RouteExcelConstants::TITLE_ORIGIN_BRANCH . ": '{$routeData[RouteExcelConstants::ORIGIN_BRANCH]}'.</li>
                                <li>" . RouteExcelConstants::TITLE_DESTINATION_BRANCH . ": '{$routeData[RouteExcelConstants::DESTINATION_BRANCH]}'.</li>
                            </ul>
                        ";
                    } else {
                        // Se crea la ruta
                        $route = new Route(
                            null,
                            new RouteTransportMethod($transportMethodId),
                            new RouteSupplier($providerId),
                            new RouteBranch($originBranchId),
                            new RouteBranch($destinationBranchId),
                            isset($routeData[RouteExcelConstants::AMOUNT_FULL_TRUCK]) ? $routeData[RouteExcelConstants::AMOUNT_FULL_TRUCK] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_1]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_1] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_2]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_2] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_3]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_3] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_4]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_4] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_5]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_5] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_6]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_6] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_7]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_7] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_8]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_8] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_9]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_9] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VEHICLE_10]) ? $routeData[RouteExcelConstants::AMOUNT_VEHICLE_10] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_SUV]) ? $routeData[RouteExcelConstants::AMOUNT_SUV] : 0,
                            isset($routeData[RouteExcelConstants::AMOUNT_VAN]) ? $routeData[RouteExcelConstants::AMOUNT_VAN] : 0
                        );

                        try {
                            $createdRouteId = $this->routeRepository->store($route);
                            if ($createdRouteId) array_push($this->managedRoutes['created'], $createdRouteId);
                        } catch (\Exception $e) {
                            $this->appendDivider();
                            $this->errors[] =
                                "Error en la creación de la ruta:
                                <ul>
                                    <li>" . RouteExcelConstants::TITLE_TRANSPORT_METHOD . ": '{$routeData[RouteExcelConstants::TRANSPORT_METHOD]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_PROVIDERID . ": '{$routeData[RouteExcelConstants::PROVIDERID]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_ORIGIN_BRANCH . ": '{$routeData[RouteExcelConstants::ORIGIN_BRANCH]}'.</li>
                                    <li>" . RouteExcelConstants::TITLE_DESTINATION_BRANCH . ": '{$routeData[RouteExcelConstants::DESTINATION_BRANCH]}'.</li>
                                </ul>
                            ";
                        }
                    }
                }
            }
        }
    }


    private function verifyFloatValid(string $column, string $value): ?float
    {
        $value = preg_replace('/[^\d.,]/', '', $value);
        $value = str_replace(',', '.', $value);
        if (!is_numeric($value)) {
            $this->errors[] = sprintf("El %s '%s' no es un número correcto.", strtolower($column), $value);
        } else {
            $value = floatval($value);
            if ($value < 0) {
                $this->errors[] = sprintf("El %s '%d' no puede ser negativo.", strtolower($column), $value);
            }
        }

        return $value;
    }

    private function checkBranch($value, string $field, string $type): ?Branch
    {
        try {
            return $this->branchCollection->getByProperty($value, $field);
        } catch (\Exception $e) {
            $this->errors[] = sprintf("La %s con ID/IATA '%s' no existe en el sístema.", strtolower($type), strval($value));
            return null;
        }
    }

    private function appendDivider(): void
    {
        if (count($this->errors) > 0) $this->errors[] = "<hr />";
    }
}
