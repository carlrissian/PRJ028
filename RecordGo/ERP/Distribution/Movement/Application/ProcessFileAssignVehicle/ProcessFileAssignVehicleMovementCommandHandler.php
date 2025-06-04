<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ProcessFileAssignVehicle;

use SplFileInfo;
use Shared\Domain\Criteria\Filter;
use Distribution\Vehicle\Domain\Vehicle;
use Distribution\Movement\Domain\Movement;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Movement\Domain\VehicleLine;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Movement\Domain\VehicleRecords;
use Distribution\Movement\Domain\MovementCriteria;
use Distribution\Vehicle\Domain\VehicleCollection;
use Distribution\Vehicle\Domain\VehicleRepository;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\SaleMethod\Domain\SaleMethodCriteria;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Distribution\Movement\Domain\Vehicle\VehicleStatus;
use Distribution\Movement\Domain\VehicleLineCollection;
use Distribution\SaleMethod\Domain\SaleMethodCollection;
use Distribution\SaleMethod\Domain\SaleMethodRepository;
use Distribution\Vehicle\Domain\VehicleToAssignCriteria;
use Distribution\Movement\Domain\Vehicle\Vehicle as MovementVehicle;
use Distribution\Movement\Domain\AssignVehicle\AssignVehicleConstants;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleCriteria;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleCollection;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleRepository;
use Distribution\Movement\Domain\AssignVehicle\AssignVehicleExcelException;

class ProcessFileAssignVehicleMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * @var BusinessUnitArticleRepository
     */
    private BusinessUnitArticleRepository $businessUnitArticleRepository;

    /**
     * @var SaleMethodRepository
     */
    private SaleMethodRepository $saleMethodRepository;

    /**
     * @var Movement
     */
    private $movement;

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
    private ?array $vehiclesExcel;

    /**
     * @var VehicleCollection
     */
    private VehicleCollection $vehiclesToAssign;

    /**
     * @var BusinessUnitArticleCollection
     */
    private BusinessUnitArticleCollection $businessUnitArticleCollection;

    /**
     * @var SaleMethodCollection
     */
    private SaleMethodCollection $saleMethodCollection;

    /**
     * @var array|null
     */
    private ?array $managedVehicles;

    /**
     * @param MovementRepository $movementRepository
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(
        MovementRepository $movementRepository,
        VehicleRepository $vehicleRepository,
        BusinessUnitArticleRepository $businessUnitArticleRepository,
        SaleMethodRepository $saleMethodRepository
    ) {
        $this->movementRepository = $movementRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->businessUnitArticleRepository = $businessUnitArticleRepository;
        $this->saleMethodRepository = $saleMethodRepository;

        $this->headers = AssignVehicleConstants::toArray();
        $this->vehiclesToAssign = new VehicleCollection([]);
        $this->businessUnitArticleCollection = new BusinessUnitArticleCollection([]);
        $this->saleMethodCollection = new SaleMethodCollection([]);

        $this->errors = [];
        $this->managedVehicles = [
            "assigned" => [],
            "notAssigned" => [],
        ];
    }

    /**
     * @param ProcessFileAssignVehicleMovementCommand $command
     * @return ProcessFileAssignVehicleMovementResponse
     */
    final public function handle(ProcessFileAssignVehicleMovementCommand $command): ProcessFileAssignVehicleMovementResponse
    {
        $this->movement = $this->movementRepository->getById($command->getMovementId());
        if (empty($this->movement)) {
            $this->errors[] = "Error getting movement.";
            throw new AssignVehicleExcelException('', $this->errors, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if (in_array($this->movement->getMovementStatus()->getId(), [intval(ConstantsJsonFile::getValue('TRANSPORTSTATUS_FINISHED')), intval(ConstantsJsonFile::getValue('TRANSPORTSTATUS_CANCELLED'))], true)) {
            $this->errors[] = "El movimiento se encuentra finalizado/cancelado. No se pueden asignar vehículos.";
            throw new AssignVehicleExcelException('', $this->errors, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->vehiclesExcel = $this->checkExcelFile($command->getFile());

        if (empty($this->errors)) {
            $this->verifyVehicles();
        }

        if (empty($this->errors)) {
            $this->manageVehicles();
        }

        if (!empty($this->errors)) {
            throw new AssignVehicleExcelException('errorAssignVehiclesNotification', $this->errors);
        }

        return new ProcessFileAssignVehicleMovementResponse(true, 'AssignVehiclesSuccessNotification', $this->managedVehicles);
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

        if (
            ($this->movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER')))
            && ($countHeaders - 1) > 10
            && ($this->movement->getTransportMethod()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTMETHOD_ROAD')))
        ) {
            $this->errors[] = 'El límite máximo de vehículos a asignar para movimientos con método de transporte por carretera es de 10 unidades';
        }

        if ($countHeaders == 1) {
            $this->errors[] = "No se han introducido datos de vehículos.";
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

            $finalHeaders[] = AssignVehicleConstants::getHeader($headerName);
        }

        foreach ($this->headers as $field) {
            if (!in_array($field, $headers, true)) {
                $this->errors[] = sprintf('Las siguientes columnas son obligatorias: %s', implode(', ', array_map(function ($header) {
                    return "'$header'";
                }, $this->headers)));
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

        // Matrícula y bastidor
        if (!array_key_exists(AssignVehicleConstants::LICENSE_PLATE, $dataColumn) && !array_key_exists(AssignVehicleConstants::VIN, $dataColumn)) {
            $this->errors[] = sprintf('Debes insertar la %s o el %s del vehículo en la fila %d', strtolower(AssignVehicleConstants::TITLE_LICENSE_PLATE), strtolower(AssignVehicleConstants::TITLE_VIN), ($countHeaders + 1));
        }

        return $dataColumn;
    }

    private function verifyVehicles(): void
    {
        $licensePlateList = array_map('strtoupper', array_column($this->vehiclesExcel, AssignVehicleConstants::LICENSE_PLATE));
        $vinList = array_map('strtoupper', array_column($this->vehiclesExcel, AssignVehicleConstants::VIN));
        $filterCollection = new FilterCollection([]);
        if (!empty($licensePlateList)) $filterCollection->add(new Filter('LICENSEPLATEIN', new FilterOperator(FilterOperator::IN), $licensePlateList));
        if (!empty($vinList)) $filterCollection->add(new Filter('VININ', new FilterOperator(FilterOperator::IN), $vinList));
        $vehicleCollection = $this->vehicleRepository->getVehiclesToAssignBy(new VehicleToAssignCriteria($filterCollection))->getCollection();

        // Datos de vehículo
        foreach ($this->vehiclesExcel as $vehicleData) {
            $vehicle = null;

            if (isset($vehicleData[AssignVehicleConstants::LICENSE_PLATE])) {
                // Búsqueda por matrícula
                try {
                    /**
                     * @var Vehicle $vehicle
                     */
                    $vehicle = $vehicleCollection->getByProperty($vehicleData[AssignVehicleConstants::LICENSE_PLATE], 'licensePlate');
                } catch (\Exception $e) {
                    if (isset($vehicleData[AssignVehicleConstants::VIN])) {
                        $this->errors[] = sprintf(
                            "El vehículo con %s '%s' y %s '%s' no existe en el sístema.",
                            strtolower(AssignVehicleConstants::TITLE_LICENSE_PLATE),
                            $vehicleData[AssignVehicleConstants::LICENSE_PLATE],
                            strtolower(AssignVehicleConstants::TITLE_VIN),
                            $vehicleData[AssignVehicleConstants::VIN]
                        );
                    } else {
                        $this->errors[] = sprintf(
                            "El vehículo con %s '%s' no existe en el sístema.",
                            strtolower(AssignVehicleConstants::TITLE_LICENSE_PLATE),
                            $vehicleData[AssignVehicleConstants::LICENSE_PLATE]
                        );
                    }
                }
            } elseif (isset($vehicleData[AssignVehicleConstants::VIN])) {
                // Búsqueda por bastidor
                try {
                    /**
                     * @var Vehicle $vehicle
                     */
                    $vehicle = $vehicleCollection->getByProperty($vehicleData[AssignVehicleConstants::VIN], 'vin');
                } catch (\Exception $e) {
                    if (isset($vehicleData[AssignVehicleConstants::LICENSE_PLATE])) {
                        $this->errors[] = sprintf(
                            "El vehículo con %s '%s' y %s '%s' no existe en el sístema.",
                            strtolower(AssignVehicleConstants::TITLE_LICENSE_PLATE),
                            $vehicleData[AssignVehicleConstants::LICENSE_PLATE],
                            strtolower(AssignVehicleConstants::TITLE_VIN),
                            $vehicleData[AssignVehicleConstants::VIN]
                        );
                    } else {
                        $this->errors[] = sprintf(
                            "El vehículo con %s '%s' no existe en el sístema.",
                            strtolower(AssignVehicleConstants::TITLE_VIN),
                            $vehicleData[AssignVehicleConstants::VIN]
                        );
                    }
                }
            }

            if (!is_null($vehicle)) {
                $this->vehiclesToAssign->add($vehicle);
            }
        }
    }

    private function manageVehicles(): void
    {
        $movementCarrierVehicles = [];
        $vehicleLineCollection =  $this->movement->getVehicleLineCollection() ?? new VehicleLineCollection([]);

        // Obtenemos movimientos por transportista no finalizados/cancelados
        if ($this->movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'))) {
            $movementCriteria = new MovementCriteria(
                new FilterCollection([
                    new Filter('TRANSPORTTYPEID', new FilterOperator(FilterOperator::EQUAL), intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'))),
                    new Filter('TRANSPORTSTATUSID', new FilterOperator(FilterOperator::IN), [intval(ConstantsJsonFile::getValue('TRANSPORTSTATUS_PENDING')), intval(ConstantsJsonFile::getValue('TRANSPORTSTATUS_IN_PROGRESS'))])
                ])
            );
            try {
                $movementCarrierCollection = $this->movementRepository->getBy($movementCriteria)->getCollection();
            } catch (\Exception $e) {
                $this->errors[] = "Se ha producido un error durante la obtención de movimientos por transportista existentes en el sistema.";
                throw new AssignVehicleExcelException('', $this->errors, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($movementCarrierCollection->count() > 0) {
                // Eliminamos el movimiento actual de la colección, por si acaso y nos lo devuelven en la consulta
                $movementCarrierCollection->removeByProperty($this->movement->getId(), 'id');
                // Recogemos los ID´s de los  movimientos
                $movementCarrierIds = array_map(function ($movement) {
                    return $movement->getId();
                }, $movementCarrierCollection->toArray());

                // Recogemos los ID´s de los vehículos asignados a los movimientos
                foreach ($movementCarrierIds as $movementId) {
                    try {
                        $movementVehicleLineCollection = $this->movementRepository->getAssignedVehicles($movementId, new MovementCriteria())->getCollection();
                        if ($movementVehicleLineCollection->count() > 0) {
                            $movementCarrierVehicles[] = [
                                'id' => $movementId,
                                'vehicleIds' => array_map(function ($line) {
                                    return $line->getVehicle()->getId();
                                }, $movementVehicleLineCollection->toArray())
                            ];
                        }
                    } catch (\Exception $e) {
                        $this->errors[] = "Se ha producido un error durante la obtención de los vehículos asignados de los movimientos por transportista existentes en el sistema.";
                        throw new AssignVehicleExcelException('', $this->errors, Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }
            }

            if (
                $this->movement->getTransportMethod()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTMETHOD_ROAD')) &&
                $this->movement->getVehicleLineCollection()->count() > 0 && ($this->movement->getVehicleLineCollection()->count() + $this->vehiclesToAssign->count()) > 10
            ) {
                $this->errors[] = 'El límite máximo de vehículos a asignar para movimientos con método de transporte por carretera es de 10 unidades';
                throw new AssignVehicleExcelException('', $this->errors, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }


        /**
         * @var Vehicle $vehicle
         */
        foreach ($this->vehiclesToAssign as $vehicle) {
            $messageVehicle = sprintf(
                "ID: %d. %s / %s: '%s' / '%s'.",
                $vehicle->getId(),
                AssignVehicleConstants::TITLE_LICENSE_PLATE,
                AssignVehicleConstants::TITLE_VIN,
                $vehicle->getLicensePlate(),
                $vehicle->getVin(),
            );
            $errorMessageReasons = [];


            // Comprobación de líneas existentes
            if ($this->movement->getVehicleLineCollection()->count() > 0) {
                /**
                 * @var VehicleLine $vehicleLine
                 */
                $vehicleLine = current(array_filter($this->movement->getVehicleLineCollection()->toArray(), function ($line) use ($vehicle) {
                    return $line->getVehicle()->getId() === $vehicle->getId();
                }));

                if ($vehicleLine) {
                    array_push(
                        $errorMessageReasons,
                        $vehicleLine->getVehicleDelete() ? "El vehículo ya fue asignado al movimiento y ha sido eliminado. No se puede volver a asignar." : "El vehículo ya está asignado al movimiento."
                    );
                }
            }

            // Comprobaciones para movimientos por transportista
            if ($this->movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'))) {
                // Si el vehículo ya está asignado a otro movimiento por transportista, no se puede asignar.
                foreach ($movementCarrierVehicles as $movement) {
                    if (in_array($vehicle->getId(), $movement['vehicleIds'], true)) {
                        array_push(
                            $errorMessageReasons,
                            sprintf("El vehículo no se puede asignar al movimiento porque ya está asignado a otro movimiento.<br>ID del movmiento: '%d'", $movement['id'])
                        );
                        // Salimos del bucle, porque dos movimientos no pueden tener el mismo vehículo asignado.
                        break;
                    }
                }

                // TODO NO MVP: 
                /**
                 * "Si el vehículo está en TALLER y tiene una fecha de salida prevista de taller superior a la fecha de carga prevista, tampoco se admitirá para la asignación. 
                 * => Hasta que no esté operativo el satélite de Mantenimento no podrá ponerse este campo como obligatorio ni añadirse lógica alguna."
                 * 
                 * @link https://recordgo.atlassian.net/wiki/spaces/DIS/pages/733478958/Gestionar+Veh+culos+Movimientos+Transportista#Criterios-de-Aceptaci%C3%B3n-(DoD)
                 */
                // Si el vehículo está en taller y su fecha de salida del taller prevista es superior a la fecha de carga prevista del movimiento, no se puede asignar.
                // if (
                //     in_array(
                //         $vehicle->getVehicleStatus()->getId(),
                //         [
                //             intval(ConstantsJsonFile::getValue('CARSTATUS_MAINTENANCE_WORKSHOP')),
                //             intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT_WORKSHOP')),
                //             intval(ConstantsJsonFile::getValue('CARSTATUS_MECHANICAL_WORKSHOP')),
                //             intval(ConstantsJsonFile::getValue('CARSTATUS_WARRANTY_WORKSHOP')),
                //             intval(ConstantsJsonFile::getValue('CARSTATUS_BODY_WORKSHOP')),
                //             intval(ConstantsJsonFile::getValue('CARSTATUS_WORKSHOP_SALE')),
                //         ],
                //         true
                //     )
                //     && $vehicle->getVehicleMaintenanceEndDate()
                //     && $vehicle->getVehicleMaintenanceEndDate()->getValue()->getTimestamp() >= $this->movement->getExpectedLoadDate()->getValue()->getTimestamp()
                // ) {
                //     array_push(
                //         $errorMessageReasons,
                //         sprintf(
                //             "El vehículo no se puede asignar al movimiento porque está en taller y su fecha de salida del taller prevista es superior a la fecha de carga prevista del movimiento.<br>Fecha de salida del taller prevista: '%s'<br>Fecha de carga prevista: '%s'",
                //             $vehicle->getVehicleMaintenanceEndDate()->__toString(),
                //             $this->movement->getExpectedLoadDate()->__toString()
                //         )
                //     );
                // }

                if ($vehicle->getSaleMethod()) {
                    if ($this->businessUnitArticleCollection->count() === 0) {
                        $businessUnitArticleCriteria = new BusinessUnitArticleCriteria(
                            new FilterCollection([new Filter('U_EXO_SUBFAMILIA', new FilterOperator(FilterOperator::EQUAL), ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_U_EXO_SUBFAMILIA_CARRIER'))])
                        );
                        $this->businessUnitArticleCollection = $this->businessUnitArticleRepository->getBy($businessUnitArticleCriteria)->getCollection();
                    }
                    if ($this->saleMethodCollection->count() === 0) {
                        $this->saleMethodCollection = $this->saleMethodRepository->getBy(new SaleMethodCriteria())->getCollection();
                    }

                    // Si el articulo es buyback y el método de venta no, no se puede asignar
                    if (
                        $this->movement->getBusinessUnitArticle()->getId() === ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_TRANSPORT_BUYBACK')
                        && $vehicle->getSaleMethod()->getId() !== intval(ConstantsJsonFile::getValue('PURCHASEMETHOD_BUYBACK'))
                    ) {
                        $businessunitArticleName = $this->businessUnitArticleCollection->getByProperty(ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_TRANSPORT_BUYBACK'), 'id')->getName();
                        $saleMethodName = $this->saleMethodCollection->getByProperty(intval(ConstantsJsonFile::getValue('PURCHASEMETHOD_BUYBACK')), 'id')->getName();
                        $vehicleSaleMethodName = $this->saleMethodCollection->getByProperty($vehicle->getSaleMethod()->getId(), 'id')->getName();
                        array_push(
                            $errorMessageReasons,
                            sprintf(
                                "El vehículo no se puede asignar al movimiento porque el articulo de unidad de negocio es '%s' y el método de venta del vehículo no es '%s'.<br>Método de venta del vehículo: '%s'",
                                $businessunitArticleName,
                                $saleMethodName,
                                $vehicleSaleMethodName
                            )
                        );
                    }

                    // Si el artículo es venta B2B o B2C y el método de venta no es risk, no se puede asignar
                    if (
                        in_array($this->movement->getBusinessUnitArticle()->getId(), [ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_TRANSPORT_B2B'), ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_TRANSPORT_B2C')])
                        && $vehicle->getSaleMethod()->getId() !== intval(ConstantsJsonFile::getValue('PURCHASEMETHOD_RISK'))
                    ) {
                        $businessunitArticleName = $this->businessUnitArticleCollection->getByProperty($this->movement->getBusinessUnitArticle()->getId(), 'id')->getName();
                        $saleMethodName = $this->saleMethodCollection->getByProperty(intval(ConstantsJsonFile::getValue('PURCHASEMETHOD_RISK')), 'id')->getName();
                        $vehicleSaleMethodName = $this->saleMethodCollection->getByProperty($vehicle->getSaleMethod()->getId(), 'id')->getName();
                        array_push(
                            $errorMessageReasons,
                            sprintf(
                                "El vehículo no se puede asignar al movimiento porque el articulo de unidad de negocio es '%s' y el método de venta no es '%s'.<br>Método de venta del vehículo: '%s'",
                                $businessunitArticleName,
                                $saleMethodName,
                                $vehicleSaleMethodName
                            )
                        );
                    }
                }

                // Si las fechas de inicio/fin de bloqueo del vehículo están dentro del rango de fechas del movimiento, no se puede asignar.
                if ($vehicle->getInitBlockageDate() && $vehicle->getEndBlockageDate()) {
                    if (
                        $vehicle->getInitBlockageDate()->getValue()->getTimestamp() >= $this->movement->getExpectedLoadDate()->getValue()->getTimestamp()
                        && $vehicle->getEndBlockageDate()->getValue()->getTimestamp() <= $this->movement->getExpectedLoadDate()->getValue()->getTimestamp()
                    ) {
                        array_push(
                            $errorMessageReasons,
                            sprintf(
                                "El vehículo no se puede asignar al movimiento porque las fechas de inicio/fin de bloqueo del vehículo están dentro del rango de fechas del movimiento.<br>Fecha de inicio de bloqueo: '%s'<br>Fecha de fin de bloqueo: '%s'<br>Fecha de carga prevista: '%s'",
                                $vehicle->getInitBlockageDate()->__toString(),
                                $vehicle->getEndBlockageDate()->__toString(),
                                $this->movement->getExpectedLoadDate()->__toString()
                            )
                        );
                    }
                }

                // Si el artículo es distribución y su fecha de fin de alquiler es inferior a la fecha de carga prevista del movimiento, no se puede asignar.
                if (
                    $this->movement->getBusinessUnitArticle()->getId() === ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_TRANSPORT_DISTRIBUTION')
                    && $vehicle->getRentingEndDate()
                    && $vehicle->getRentingEndDate()->getValue()->getTimestamp() <= $this->movement->getExpectedLoadDate()->getValue()->getTimestamp()
                ) {
                    $businessunitArticleName = $this->businessUnitArticleCollection->getByProperty(ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_TRANSPORT_DISTRIBUTION'), 'id')->getName();
                    array_push(
                        $errorMessageReasons,
                        sprintf(
                            "El vehículo no se puede asignar al movimiento porque el artículo de unidad de negocio es '%s' y la fecha de fin de alquiler del vehículo es inferior a la fecha de carga prevista del movimiento.<br>Fecha fin de alquiler: '%s'<br>Fecha de carga prevista: '%s'",
                            $businessunitArticleName,
                            $vehicle->getRentingEndDate()->__toString(),
                            $this->movement->getExpectedLoadDate()->__toString()
                        )
                    );
                }
            }

            $originLocationName = ($this->movement->getOriginLocation() ? $this->movement->getOriginLocation()->getName() : (($this->movement->getOriginExternalLocation()) ? $this->movement->getOriginExternalLocation()->getName() : null));
            // Si el vehículo no tiene localización, no se puede asignar.
            if ($vehicle->getLocation() === null) {
                array_push(
                    $errorMessageReasons,
                    sprintf("El vehículo no tiene una localización asignada. No se puede asignar al movimiento con localización origen '%s'.", $originLocationName)
                );
            }
            // Si el vehículo pertenece a una localización diferente, no se puede asignar.
            $originLocationId = ($this->movement->getOriginLocation() ? $this->movement->getOriginLocation()->getId() : (($this->movement->getOriginExternalLocation()) ? $this->movement->getOriginExternalLocation()->getId() : null));
            if ($vehicle->getLocation() && $vehicle->getLocation()->getId() !== $originLocationId) {
                array_push(
                    $errorMessageReasons,
                    sprintf("El vehículo no se puede asignar al movimiento porque pertenece a una localización distinta a la localización de origen del movimiento.<br>Localización: '%s'", $vehicle->getLocation()->getName())
                );
            }


            // Si el vehículo está alquilado y su fecha de fin de contrato es superior a la fecha de carga prevista del movimiento, no se puede asignar.
            if (
                $vehicle->getStatus()->getId() === intval(ConstantsJsonFile::getValue('CARSTATUS_ON_RENT'))
                && $vehicle->getRentalAgreementDropOffDate()
                && $vehicle->getRentalAgreementDropOffDate()->getValue()->getTimestamp() >= $this->movement->getExpectedLoadDate()->getValue()->getTimestamp()
            ) {
                array_push(
                    $errorMessageReasons,
                    sprintf(
                        "El vehículo no se puede asignar al movimiento porque está alquilado y su fecha fin de contrato prevista es superior a la fecha de carga prevista del movimiento.<br>Fecha fin de contrato prevista: '%s'<br>Fecha de carga prevista: '%s'",
                        $vehicle->getReturnDate()->__toString(),
                        $this->movement->getExpectedLoadDate()->__toString()
                    )
                );
            }


            if (count($errorMessageReasons) === 0) {
                $vehicleLineCollection->add(
                    new VehicleLine(
                        new MovementVehicle(
                            $vehicle->getId(),
                            $vehicle->getLicensePlate(),
                            $vehicle->getVin(),
                            $vehicle->getStatus() ? new VehicleStatus($vehicle->getStatus()->getId()) : null
                        ),
                        null,
                        null,
                        new VehicleRecords(
                            $vehicle->getActualKms(),
                            $vehicle->getBatteryActual(),
                            $vehicle->getTankActualOctaves()
                        )
                    )
                );

                array_push($this->managedVehicles['assigned'], $messageVehicle);
            } else {
                $errorMessageReasons = array_map(function ($reason) {
                    return "<li>{$reason}</li>";
                }, $errorMessageReasons);
                array_push(
                    $this->managedVehicles['notAssigned'],
                    sprintf("%s<br>Motivos:<br><ul>%s</ul>", $messageVehicle, implode('', $errorMessageReasons))
                );
            }
        }

        // Actualización de unbidades esperadas
        $oldCollectionCount = $this->movement->getVehicleLineCollection()->count();
        $this->movement->setVehicleLineCollection($vehicleLineCollection);

        if ($this->movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'))) {
            if ($this->movement->getTransportMethod()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTMETHOD_ROAD'))) {
                $this->movement->setVehicleUnits(($this->movement->getVehicleLineCollection()->count() < 10) ? $vehicleLineCollection->count() : $oldCollectionCount);
            } else {
                if ($vehicleLineCollection->count() > $this->movement->getVehicleUnits()) $this->movement->setVehicleUnits($vehicleLineCollection->count());
            }
        } else {
            if ($vehicleLineCollection->count() > $this->movement->getVehicleUnits()) $this->movement->setVehicleUnits($vehicleLineCollection->count());
        }


        try {
            $response = $this->movementRepository->update($this->movement);
            if (!$response->getOperationResponse()->wasSuccess()) {
                $this->errors['reason'] = $response->getOperationResponse()->getMessage();
                $this->errors['assign'] = [];
                foreach ($vehicleLineCollection as $line) {
                    $vehicle = $line->getVehicle();
                    array_push(
                        $this->errors['assign'],
                        sprintf(
                            "ID: %d. %s / %s: '%s' / '%s'.",
                            $vehicle->getId(),
                            AssignVehicleConstants::TITLE_LICENSE_PLATE,
                            AssignVehicleConstants::TITLE_VIN,
                            $vehicle->getLicensePlate(),
                            $vehicle->getVin()
                        )
                    );
                }
                if (count($this->managedVehicles['notAssigned']) > 0) $this->errors['affectedVehicles']['notAssigned'] = $this->managedVehicles['notAssigned'];

                throw new AssignVehicleExcelException('errorAssignVehiclesNotification', $this->errors, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            $this->errors['assign'] = [];
            foreach ($vehicleLineCollection as $line) {
                $vehicle = $line->getVehicle();
                array_push(
                    $this->errors['assign'],
                    sprintf(
                        "ID: %d. %s / %s: '%s' / '%s'.",
                        $vehicle->getId(),
                        AssignVehicleConstants::TITLE_LICENSE_PLATE,
                        AssignVehicleConstants::TITLE_VIN,
                        $vehicle->getLicensePlate(),
                        $vehicle->getVin()
                    )
                );
            }
            if (count($this->managedVehicles['notAssigned']) > 0) $this->errors['affectedVehicles']['notAssigned'] = $this->managedVehicles['notAssigned'];

            throw new AssignVehicleExcelException('errorAssignVehiclesNotification', $this->errors, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
