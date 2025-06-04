<?php

declare(strict_types=1);

namespace Distribution\UpdateData\Application\ProcessFileUpdateData;

use DateTime;
use Exception;
use SplFileInfo;
use Shared\Domain\Criteria\Filter;
use Distribution\Vehicle\Domain\Vehicle;
use Distribution\Location\Domain\Location;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\Vehicle\Domain\VehicleCriteria;
use Distribution\Vehicle\Domain\VehicleToUpdate;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\UpdateData\Domain\FileRepository;
use Distribution\Vehicle\Domain\VehicleRepository;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Location\Domain\LocationCollection;
use Distribution\Location\Domain\LocationRepository;
use Distribution\VehicleStatus\Domain\VehicleStatus;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Distribution\UpdateData\Domain\VehicleExcelConstants;
use Distribution\Vehicle\Domain\VehiclesToUpdateCriteria;
use Distribution\Vehicle\Domain\VehicleToUpdateCollection;
use Distribution\Vehicle\Domain\Location as DomainLocation;
use Distribution\UpdateData\Domain\UpdateDataExcelException;
use Distribution\VehicleStatus\Domain\VehicleStatusCriteria;
use Distribution\VehicleStatus\Domain\VehicleStatusCollection;
use Distribution\VehicleStatus\Domain\VehicleStatusRepository;
use Distribution\Vehicle\Domain\VehicleStatus as DomainVehicleStatus;

class ProcessFileUpdateDataCommandHandler
{
    /**
     * @var FileRepository
     */
    private FileRepository $fileRepository;

    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * @var VehicleStatusRepository
     */
    private VehicleStatusRepository $vehicleStatusRepository;

    /**
     * @var VehicleStatusCollection|null
     */
    private $vehicleStatusCollection;

    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;

    /**
     * @var LocationCollection|null
     */
    private $locationCollection;

    /**
     * @var VehicleToUpdateCollection|null
     */
    private VehicleToUpdateCollection $vehicleCollection;

    /**
     * @var array
     */
    private array $headers;

    /**
     * @var array
     */
    private array $excelHeaders;

    /**
     * @var array
     */
    private array $excelBody;

    /**
     * @var array
     */
    private array $excelErrors;

    /**
     * @var array|null
     */
    private ?array $managedVehicles;

    /**
     * ProcessFileUpdateDataCommandHandler constructor.
     *
     * @param FileRepository $fileRepository
     * @param VehicleRepository $vehicleRepository
     * @param VehicleStatusRepository $statusRepository
     * @param LocationRepository $locationRepository
     */
    public function __construct(
        FileRepository $fileRepository,
        VehicleRepository $vehicleRepository,
        VehicleStatusRepository $vehicleStatusRepository,
        LocationRepository $locationRepository
    ) {
        $this->fileRepository = $fileRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleStatusRepository = $vehicleStatusRepository;
        $this->locationRepository = $locationRepository;

        $this->headers = VehicleExcelConstants::toArray();

        $this->excelHeaders = [];
        $this->excelBody = [];
        $this->excelErrors = [];
        $this->managedVehicles = [
            "updated" => [],
            "notUpdated" => [],
        ];

        $this->vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection();
        $this->locationCollection = $this->locationRepository->getBy(new LocationCriteria())->getCollection();
    }

    /**
     * @throws UpdateDataExcelException
     */
    final public function handle(ProcessFileUpdateDataCommand $command): ProcessFileUpdateDataResponse
    {
        // $this->excelBody = $this->checkExcelFile($command->getFile());
        [$this->excelHeaders, $excelBody] = $this->fileRepository->import($command->getFile());

        $this->checkHeaders();

        if (empty($this->excelErrors)) {
            $this->checkBody($excelBody);
        }

        if (empty($this->excelErrors)) {
            $this->verifyVehicles();
        }

        if (empty($this->excelErrors)) {
            $this->updateVehicles();
        }

        if (!empty($this->excelErrors)) {
            throw new UpdateDataExcelException('errorUpdateDataNotification', $this->excelErrors);
        }

        if (count($this->managedVehicles['notUpdated']) > 0) {
            throw new UpdateDataExcelException('errorUpdateDataNotification', $this->managedVehicles);
        }

        return new ProcessFileUpdateDataResponse(true, 'updateDataSuccessNotification', $this->managedVehicles);
    }

    private function checkHeaders(): void
    {
        if (empty($this->excelHeaders)) {
            $this->excelErrors[] = 'El archivo excel no puede estar vacío.';
        }

        foreach ($this->excelHeaders as $position => $headerName) {
            if (!in_array($headerName, $this->headers, true)) {
                $this->excelErrors[] = "La columna '$headerName' no es correcta";
            } else if (array_search($headerName, $this->headers, true) !== $position) {
                $this->excelErrors[] = "La columna '$headerName' no se puede cambiar de posición";
            }
        }

        $requiredHeaders = [
            VehicleExcelConstants::TITLE_LICENSE_PLATE,
            VehicleExcelConstants::TITLE_VIN,
        ];

        foreach ($requiredHeaders as $field) {
            if (!in_array($field, $this->excelHeaders, true)) {
                $this->excelErrors[] = sprintf('Las siguientes columnas son obligatorias: %s', implode(', ', array_map(function ($header) {
                    return "'$header'";
                }, $requiredHeaders)));
                break;
            }
        }
    }

    private function checkBody($body): void
    {
        if (empty($body)) {
            $this->excelErrors[] = 'No se han introducido datos de vehículos.';
        }

        $body = array_map(function ($bodyRow) {
            foreach ($bodyRow as $column => $value) {
                if ($column !== 'line') {
                    $bodyRow[VehicleExcelConstants::getHeader($column)] = $value;
                    unset($bodyRow[$column]);
                }
            }
            return $bodyRow;
        }, $body);

        foreach ($body as $bodyRow) {
            $formattedElement = [];

            $fieldsFilledArray = [];
            array_walk($bodyRow, function ($value, $index) use (&$fieldsFilledArray) {
                $fieldsFilledArray[] = $index !== "line" && !is_null($value) && !empty($value);
            });
            $fieldsFilled = count(array_filter($fieldsFilledArray, function ($value) {
                return $value === true;
            }));

            // Matrícula y bastidor
            if (is_null($bodyRow[VehicleExcelConstants::LICENSE_PLATE]) && is_null($bodyRow[VehicleExcelConstants::VIN])) {
                $this->excelErrors[] = sprintf('Debes insertar la %s o el %s del vehículo en la fila %d', strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE), strtolower(VehicleExcelConstants::TITLE_VIN), $bodyRow['line']);
            } else if ((is_null($bodyRow[VehicleExcelConstants::LICENSE_PLATE]) || is_null($bodyRow[VehicleExcelConstants::VIN])) && $fieldsFilled < 2) {
                $this->excelErrors[] = sprintf('Debes insertar la %s y/o el %s del vehículo, y otro campo como mínimo en la fila %d', strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE), strtolower(VehicleExcelConstants::TITLE_VIN), $bodyRow['line']);
            }

            // Estado
            $vehicleStatus = null;
            if (!is_null($bodyRow[VehicleExcelConstants::STATUS])) {
                $vehicleStatus = (is_numeric($bodyRow[VehicleExcelConstants::STATUS])) ?
                    $this->checkVehicleStatus(intval($bodyRow[VehicleExcelConstants::STATUS]), 'id', false)
                    : $this->checkVehicleStatus($bodyRow[VehicleExcelConstants::STATUS], 'name', false);
                if (is_null($vehicleStatus)) $this->excelErrors[] = sprintf('El %s del vehículo insertado en la fila %d no es correcto', strtolower(VehicleExcelConstants::TITLE_STATUS), $bodyRow['line']);
            }

            // Localización
            $location = null;
            if (!is_null($bodyRow[VehicleExcelConstants::LOCATION])) {
                $location = (is_numeric($bodyRow[VehicleExcelConstants::LOCATION])) ?
                    $this->checkLocation(intval($bodyRow[VehicleExcelConstants::LOCATION]), 'id', false)
                    : $this->checkLocation($bodyRow[VehicleExcelConstants::LOCATION], 'name', false);
                if (is_null($location)) $this->excelErrors[] = sprintf('La %s del vehículo insertado en la fila %d no es correcto', strtolower(VehicleExcelConstants::TITLE_LOCATION), $bodyRow['line']);
            }

            // Fechas alquiler
            if (
                !is_null($bodyRow[VehicleExcelConstants::RENTING_INIT_DATE]) && !is_null($bodyRow[VehicleExcelConstants::RENTING_END_DATE]) &&
                $bodyRow[VehicleExcelConstants::RENTING_INIT_DATE] > $bodyRow[VehicleExcelConstants::RENTING_END_DATE]
            ) {
                $this->excelErrors[] = sprintf('La %s es mayor a la %s en la fila %d', strtolower(VehicleExcelConstants::TITLE_RENTING_INIT_DATE), strtolower(VehicleExcelConstants::TITLE_RENTING_END_DATE), $bodyRow['line']);
            }

            // Fechas bloqueo
            if (
                (!is_null($bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_START]) && is_null($bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_END])) ||
                (!is_null($bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_END]) && is_null($bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_START]))
            ) {
                $this->excelErrors[] = sprintf('Debes insertar ambas fechas de inicio y fin de bloqueo en la fila %d', $bodyRow['line']);
            }
            if (
                !is_null($bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_START]) && !is_null($bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_END]) &&
                $bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_START] > $bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_END]
            ) {
                $this->excelErrors[] = sprintf('La %s es mayor a la %s en la fila %d', strtolower(VehicleExcelConstants::TITLE_DATE_BLOCKAGE_START), strtolower(VehicleExcelConstants::TITLE_DATE_BLOCKAGE_END), $bodyRow['line']);
            }
            if (!is_null($bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_START]) && !is_null($bodyRow[VehicleExcelConstants::DATE_BLOCKAGE_END]) && is_null($bodyRow[VehicleExcelConstants::BLOCKAGE_COMMENTS])) {
                $this->excelErrors[] = sprintf('Debes insertar un %s en la fila %d', strtolower(VehicleExcelConstants::TITLE_BLOCKAGE_COMMENTS), $bodyRow['line']);
            }

            // Fecha devolución
            if (!is_null($bodyRow[VehicleExcelConstants::RENTING_END_DATE]) && !is_null($bodyRow[VehicleExcelConstants::CHECK_IN_DATE])) {
                if ($bodyRow[VehicleExcelConstants::RENTING_END_DATE] > $bodyRow[VehicleExcelConstants::CHECK_IN_DATE]) {
                    $this->excelErrors[] = sprintf('La %s es mayor a la %s en la fila %d', VehicleExcelConstants::TITLE_RENTING_END_DATE, VehicleExcelConstants::TITLE_CHECK_IN_DATE, $bodyRow['line']);
                }
            }

            if (!empty($bodyRow[VehicleExcelConstants::LICENSE_PLATE]) || !empty($bodyRow[VehicleExcelConstants::VIN])) {
                foreach ($bodyRow as $column => $value) {
                    switch ($column) {
                        case VehicleExcelConstants::STATUS:
                            $formattedElement[$column] = $vehicleStatus;
                            break;
                        case VehicleExcelConstants::LOCATION:
                            $formattedElement[$column] = $location;
                            break;
                        case VehicleExcelConstants::RENTING_INIT_DATE:
                        case VehicleExcelConstants::RENTING_END_DATE:
                        case VehicleExcelConstants::CHECK_IN_DATE:
                        case VehicleExcelConstants::DATE_BLOCKAGE_START:
                        case VehicleExcelConstants::DATE_BLOCKAGE_END:
                            $formattedElement[$column] = $value ? $this->verifyDateValid($column, $value) : $value;
                            break;
                        case VehicleExcelConstants::BLOCKAGE_COMMENTS:
                            $formattedElement[$column] = $value ? ((preg_match('//u', $value) !== 1) ? iconv('ISO-8859-1', 'UTF-8', $value) : $value) : $value;
                            break;
                        default:
                            $formattedElement[$column] = $value;
                            break;
                    }
                }
            }

            $this->excelBody[] = $formattedElement;
        }
    }



    private function verifyVehicles(): void
    {
        //set uppercase to license plate
        $licensePlateList = array_map('strtoupper', array_column($this->excelBody, VehicleExcelConstants::LICENSE_PLATE));

        $vinList = array_column($this->excelBody, VehicleExcelConstants::VIN);
        $filterCollection = new FilterCollection([]);
        if (!empty($licensePlateList)) $filterCollection->add(new Filter('LICENSEPLATEIN', new FilterOperator(FilterOperator::IN), $licensePlateList));
        if (!empty($vinList)) $filterCollection->add(new Filter('VININ', new FilterOperator(FilterOperator::IN), $vinList));
        $this->vehicleCollection = $this->vehicleRepository->getVehiclesToUpdateBy(new VehiclesToUpdateCriteria($filterCollection));

        // Datos de vehículo
        foreach ($this->excelBody as $vehicleData) {
            $vehicle = null;

            if (isset($vehicleData[VehicleExcelConstants::LICENSE_PLATE])) {
                // Búsqueda por matrícula
                try {
                    /**
                     * @var VehicleToUpdate $vehicle
                     */
                    $vehicle = $this->vehicleCollection->getByProperty(strtoupper($vehicleData[VehicleExcelConstants::LICENSE_PLATE]), 'licensePlate');
                } catch (Exception $e) {
                    if (isset($vehicleData[VehicleExcelConstants::VIN])) {
                        $this->excelErrors[] = sprintf(
                            "El vehículo con %s '%s' y %s '%s' no existe en el sístema.",
                            strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                            $vehicleData[VehicleExcelConstants::LICENSE_PLATE],
                            strtolower(VehicleExcelConstants::TITLE_VIN),
                            $vehicleData[VehicleExcelConstants::VIN]
                        );
                    } else {
                        $this->excelErrors[] = sprintf(
                            "El vehículo con %s '%s' no existe en el sístema.",
                            strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                            $vehicleData[VehicleExcelConstants::LICENSE_PLATE]
                        );
                    }
                }
            } elseif (isset($vehicleData[VehicleExcelConstants::VIN])) {
                // Búsqueda por bastidor
                try {
                    /**
                     * @var VehicleToUpdate $vehicle
                     */
                    $vehicle = $this->vehicleCollection->getByProperty($vehicleData[VehicleExcelConstants::VIN], 'vin');
                } catch (Exception $e) {
                    if (isset($vehicleData[VehicleExcelConstants::LICENSE_PLATE])) {
                        $this->excelErrors[] = sprintf(
                            "El vehículo con %s '%s' y %s '%s' no existe en el sístema.",
                            strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                            $vehicleData[VehicleExcelConstants::LICENSE_PLATE],
                            strtolower(VehicleExcelConstants::TITLE_VIN),
                            $vehicleData[VehicleExcelConstants::VIN]
                        );
                    } else {
                        $this->excelErrors[] = sprintf(
                            "El vehículo con %s '%s' no existe en el sístema.",
                            strtolower(VehicleExcelConstants::TITLE_VIN),
                            $vehicleData[VehicleExcelConstants::VIN]
                        );
                    }
                }
            }

            if (!is_null($vehicle)) {
                // Comprobación fechas de alquiler
                if (isset($vehicleData[VehicleExcelConstants::RENTING_INIT_DATE]) && !isset($vehicleData[VehicleExcelConstants::RENTING_END_DATE])) {
                    // Fecha inicio de alquiler
                    if ($vehicle->getRentingEndDate() && $vehicleData[VehicleExcelConstants::RENTING_INIT_DATE]->getTimestamp() > $vehicle->getRentingEndDate()->getValue()->getTimestamp()) {
                        $this->excelErrors[] = sprintf(
                            "El vehículo con %s '%s' y %s '%s' tiene una %s inferior a la %s insertada. %s: '%s'",
                            strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                            $vehicle->getLicensePlate(),
                            strtolower(VehicleExcelConstants::TITLE_VIN),
                            $vehicle->getVin(),
                            strtolower(VehicleExcelConstants::TITLE_RENTING_END_DATE),
                            strtolower(VehicleExcelConstants::TITLE_RENTING_INIT_DATE),
                            VehicleExcelConstants::TITLE_RENTING_END_DATE,
                            $vehicle->getRentingEndDate()
                        );
                    }
                } elseif (isset($vehicleData[VehicleExcelConstants::RENTING_END_DATE]) && !isset($vehicleData[VehicleExcelConstants::RENTING_INIT_DATE])) {
                    // Fecha fin de alquiler
                    if ($vehicle->getFirstRentDate() && $vehicle->getFirstRentDate()->getValue()->getTimestamp() > $vehicleData[VehicleExcelConstants::RENTING_END_DATE]->getTimestamp()) {
                        $this->excelErrors[] = sprintf(
                            "El vehículo con %s '%s' y %s '%s' tiene una %s superior a la %s insertada. %s: '%s'",
                            strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                            $vehicle->getLicensePlate(),
                            strtolower(VehicleExcelConstants::TITLE_VIN),
                            $vehicle->getVin(),
                            strtolower(VehicleExcelConstants::TITLE_RENTING_END_DATE),
                            strtolower(VehicleExcelConstants::TITLE_RENTING_INIT_DATE),
                            VehicleExcelConstants::TITLE_RENTING_END_DATE,
                            $vehicle->getFirstRentDate()
                        );
                    }
                }

                $rentingDateAndReturnDateChecked = isset($vehicleData[VehicleExcelConstants::RENTING_END_DATE]) && isset($vehicleData[VehicleExcelConstants::CHECK_IN_DATE]);
                if (!$rentingDateAndReturnDateChecked && isset($vehicleData[VehicleExcelConstants::RENTING_END_DATE]) && $vehicle->getReturnDate() && $vehicleData[VehicleExcelConstants::RENTING_END_DATE]->getTimestamp() > $vehicle->getReturnDate()->getValue()->getTimestamp()) {
                    $this->excelErrors[] = sprintf(
                        "El vehículo con %s '%s' y %s '%s' tiene una %s inferior a la %s insertada. %s: '%s'",
                        strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                        $vehicle->getLicensePlate(),
                        strtolower(VehicleExcelConstants::TITLE_VIN),
                        $vehicle->getVin(),
                        strtolower(VehicleExcelConstants::TITLE_CHECK_IN_DATE),
                        strtolower(VehicleExcelConstants::TITLE_RENTING_END_DATE),
                        VehicleExcelConstants::TITLE_CHECK_IN_DATE,
                        $vehicle->getReturnDate()
                    );
                }

                // Comprobación fecha de devolución
                // INFO: lógica suprimida: https://recordgo.atlassian.net/browse/P28-2822?focusedCommentId=46507
                // if (isset($vehicleData[VehicleExcelConstants::CHECK_IN_DATE]) && $vehicle->getPurchaseMethod()) {
                //     if ($vehicle->getPurchaseMethod()->getId() !== intval(ConstantsJsonFile::getValue('PURCHASEMETHOD_RISK'))) {
                //         $this->excelErrors[] = sprintf("El vehículo con %s '%s' y %s '%s' no es de tipo de compra RISK.", strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE), $vehicle->getLicensePlate(), strtolower(VehicleExcelConstants::TITLE_VIN), $vehicle->getVin());
                //     } elseif (!isset($vehicleData[VehicleExcelConstants::RENTING_END_DATE]) && $vehicle->getRentingEndDate() && $vehicle->getRentingEndDate()->getValue()->getTimestamp() > $vehicleData[VehicleExcelConstants::CHECK_IN_DATE]->getTimestamp()) {
                //         $this->excelErrors[] = sprintf(
                //             "El vehículo con %s '%s' y %s '%s' tiene una %s superior a la %s insertada. %s: '%s'",
                //             strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                //             $vehicle->getLicensePlate(),
                //             strtolower(VehicleExcelConstants::TITLE_VIN),
                //             $vehicle->getVin(),
                //             strtolower(VehicleExcelConstants::TITLE_RENTING_END_DATE),
                //             strtolower(VehicleExcelConstants::TITLE_CHECK_IN_DATE),
                //             VehicleExcelConstants::TITLE_RENTING_END_DATE,
                //             $vehicle->getRentingEndDate()
                //         );
                //     }
                // }
                if (isset($vehicleData[VehicleExcelConstants::CHECK_IN_DATE]) && !isset($vehicleData[VehicleExcelConstants::RENTING_END_DATE]) && $vehicle->getRentingEndDate() && $vehicle->getRentingEndDate()->getValue()->getTimestamp() > $vehicleData[VehicleExcelConstants::CHECK_IN_DATE]->getTimestamp()) {
                    $this->excelErrors[] = sprintf(
                        "El vehículo con %s '%s' y %s '%s' tiene una %s superior a la %s insertada. %s: '%s'",
                        strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                        $vehicle->getLicensePlate(),
                        strtolower(VehicleExcelConstants::TITLE_VIN),
                        $vehicle->getVin(),
                        strtolower(VehicleExcelConstants::TITLE_RENTING_END_DATE),
                        strtolower(VehicleExcelConstants::TITLE_CHECK_IN_DATE),
                        VehicleExcelConstants::TITLE_RENTING_END_DATE,
                        $vehicle->getRentingEndDate()
                    );
                }

                // Comprobación de estados
                if (isset($vehicleData[VehicleExcelConstants::STATUS]) && !is_null($vehicleData[VehicleExcelConstants::STATUS])) {
                    switch ($vehicle->getVehicleStatus()->getId()) {
                            // En depósito a Libre disponible
                        case intval(ConstantsJsonFile::getValue('CARSTATUS_FIRST_RENTAL_PREPARATION')):
                            if ($vehicleData[VehicleExcelConstants::STATUS]->getId() !== intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE'))) {
                                $this->excelErrors[] = sprintf(
                                    "El vehículo con %s '%s' y %s '%s' no se puede cambiar de estado '%s' a '%s'",
                                    strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                                    $vehicle->getLicensePlate(),
                                    strtolower(VehicleExcelConstants::TITLE_VIN),
                                    $vehicle->getVin(),
                                    $vehicle->getVehicleStatus()->getName(),
                                    $vehicleData[VehicleExcelConstants::STATUS]->getName()
                                ) .
                                    sprintf(
                                        "<br>Sólo se permite el cambio de estado '%s' a '%s'",
                                        $vehicle->getVehicleStatus()->getName(),
                                        $this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), 'id')->getName()
                                    );
                            }
                            break;
                            // Parada bajo reserva a Libre disponible
                        case intval(ConstantsJsonFile::getValue('CARSTATUS_STOCK')):
                            if ($vehicleData[VehicleExcelConstants::STATUS]->getId() !== intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE'))) {
                                $this->excelErrors[] = sprintf(
                                    "El vehículo con %s '%s' y %s '%s' no se puede cambiar de estado '%s' a '%s'",
                                    strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                                    $vehicle->getLicensePlate(),
                                    strtolower(VehicleExcelConstants::TITLE_VIN),
                                    $vehicle->getVin(),
                                    $vehicle->getVehicleStatus()->getName(),
                                    $vehicleData[VehicleExcelConstants::STATUS]->getName()
                                ) .
                                    sprintf(
                                        "<br>Sólo se permite el cambio de estado '%s' a '%s'",
                                        $vehicle->getVehicleStatus()->getName(),
                                        $this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), 'id')->getName()
                                    );
                            }
                            break;
                            // Trabajo interno a Libre disponible
                        case intval(ConstantsJsonFile::getValue('INTERNAL_MOVEMENT')):
                            if ($vehicleData[VehicleExcelConstants::STATUS]->getId() !== intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE'))) {
                                $this->excelErrors[] = sprintf(
                                    "El vehículo con %s '%s' y %s '%s' no se puede cambiar de estado '%s' a '%s'",
                                    strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                                    $vehicle->getLicensePlate(),
                                    strtolower(VehicleExcelConstants::TITLE_VIN),
                                    $vehicle->getVin(),
                                    $vehicle->getVehicleStatus()->getName(),
                                    $vehicleData[VehicleExcelConstants::STATUS]->getName()
                                ) .
                                    sprintf(
                                        "<br>Sólo se permite el cambio de estado '%s' a '%s'",
                                        $vehicle->getVehicleStatus()->getName(),
                                        $this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), 'id')->getName()
                                    );
                            }
                            break;
                            // Pdte venta a Parada definitiva
                        case intval(ConstantsJsonFile::getValue('CARSTATUS_PENDING_WS_SALE')):
                            if ($vehicleData[VehicleExcelConstants::STATUS]->getId() !== intval(ConstantsJsonFile::getValue('CARSTATUS_SALE'))) {
                                $this->excelErrors[] = sprintf(
                                    "El vehículo con %s '%s' y %s '%s' no se puede cambiar de estado '%s' a '%s'",
                                    strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                                    $vehicle->getLicensePlate(),
                                    strtolower(VehicleExcelConstants::TITLE_VIN),
                                    $vehicle->getVin(),
                                    $vehicle->getVehicleStatus()->getName(),
                                    $vehicleData[VehicleExcelConstants::STATUS]->getName()
                                ) .
                                    sprintf(
                                        "<br>Sólo se permite el cambio de estado '%s' a '%s'",
                                        $vehicle->getVehicleStatus()->getName(),
                                        $this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_SALE')), 'id')->getName()
                                    );
                            }
                            break;
                            // Parada definitiva a Libre disponible, Parada definitiva a Pdte venta
                        case intval(ConstantsJsonFile::getValue('CARSTATUS_SALE')):
                            if (!in_array($vehicleData[VehicleExcelConstants::STATUS]->getId(), [intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), intval(ConstantsJsonFile::getValue('CARSTATUS_PENDING_WS_SALE'))])) {
                                $this->excelErrors[] = sprintf(
                                    "El vehículo con %s '%s' y %s '%s' no se puede cambiar de estado '%s' a '%s'",
                                    strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                                    $vehicle->getLicensePlate(),
                                    strtolower(VehicleExcelConstants::TITLE_VIN),
                                    $vehicle->getVin(),
                                    $vehicle->getVehicleStatus()->getName(),
                                    $vehicleData[VehicleExcelConstants::STATUS]->getName()
                                ) .
                                    sprintf(
                                        "<br>Sólo se permite el cambio de estado '%s' a '%s'",
                                        $vehicle->getVehicleStatus()->getName(),
                                        $this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), 'id')->getName()
                                    );
                            }
                            break;
                            // Libre disponible a Parada definitiva, Libre disponible a en deposito, Libre disponible a Parada bajo reserva, Libre disponible a Trabajo interno
                        case intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')):
                            if (!in_array($vehicleData[VehicleExcelConstants::STATUS]->getId(), [ConstantsJsonFile::getValue('CARSTATUS_SALE'), ConstantsJsonFile::getValue('CARSTATUS_FIRST_RENTAL_PREPARATION'), ConstantsJsonFile::getValue('CARSTATUS_STOCK'), ConstantsJsonFile::getValue('CARSTATUS_INTERNAL_MOVEMENT')])) {
                                $this->excelErrors[] = "El vehículo con matrícula {$vehicle->getLicensePlate()} y bastidor {$vehicle->getVin()} no se puede cambiar de estado '{$vehicle->getVehicleStatus()->getName()}' a '{$vehicleData[VehicleExcelConstants::STATUS]->getName()}'.
                                                <br>Transiciones admitidas:
                                                <ul>
                                                    <li>'{$vehicle->getVehicleStatus()->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_SALE')), 'id')->getName()}'.</li>
                                                    <li>'{$vehicle->getVehicleStatus()->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_FIRST_RENTAL_PREPARATION')), 'id')->getName()}'.</li>
                                                    <li>'{$vehicle->getVehicleStatus()->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_STOCK')), 'id')->getName()}'.</li>
                                                    <li>'{$vehicle->getVehicleStatus()->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_INTERNAL_MOVEMENT')), 'id')->getName()}'.</li>
                                                </ul>
                                ";
                            }
                            break;
                        default:
                            $this->excelErrors[] = "El vehículo con matrícula {$vehicle->getLicensePlate()} y bastidor {$vehicle->getVin()} no se puede cambiar de estado '{$vehicle->getVehicleStatus()->getName()}' a '{$vehicleData[VehicleExcelConstants::STATUS]->getName()}'.
                                                <br>Transiciones admitidas:
                                                <ul>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), 'id')->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_SALE')), 'id')->getName()}', y viceversa.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), 'id')->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_FIRST_RENTAL_PREPARATION')), 'id')->getName()}', y viceversa.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), 'id')->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_STOCK')), 'id')->getName()}', y viceversa.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_AVAILABLE')), 'id')->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_INTERNAL_MOVEMENT')), 'id')->getName()}', y viceversa.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_SALE')), 'id')->getName()}' a '{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_PENDING_WS_SALE')), 'id')->getName()}', y viceversa.</li>
                                                </ul>
                            ";
                            break;
                    }
                }

                // Comprobación de localización
                if (isset($vehicleData[VehicleExcelConstants::LOCATION]) && !is_null($vehicleData[VehicleExcelConstants::LOCATION])) {
                    if ($vehicle->getLocation()->getId() === $vehicleData[VehicleExcelConstants::LOCATION]->getId()) {
                        $this->excelErrors[] = sprintf(
                            "El vehículo con %s '%s' y %s '%s' ya está en la localización '%s'. Por favor, deje el campo vacío o seleccione otra localización.",
                            strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE),
                            $vehicle->getLicensePlate(),
                            strtolower(VehicleExcelConstants::TITLE_VIN),
                            $vehicle->getVin(),
                            $vehicle->getLocation()->getName() ?? $vehicleData[VehicleExcelConstants::LOCATION]->getName()
                        );
                    }

                    if (in_array($vehicle->getVehicleStatus()->getId(), [
                        intval(ConstantsJsonFile::getValue('CARSTATUS_ON_RENT')),
                        intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT')),
                        intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT_SALE')),
                        intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD_ON_TRANSPORT')),
                        intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD_REPAIR')),
                        intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD')),
                        intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT_WORKSHOP'))
                    ])) {
                        $this->excelErrors[] = "El vehículo con matrícula {$vehicle->getLicensePlate()} y bastidor {$vehicle->getVin()} no se puede cambiar de localización '{$vehicle->getLocation()->getName()}' a '{$vehicleData[VehicleExcelConstants::LOCATION]->getName()}' porque está en estado '{$vehicle->getVehicleStatus()->getName()}'.
                                                <br>Estados no admitidos:
                                                <ul>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_ON_RENT')), 'id')->getName()}'.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT')), 'id')->getName()}'.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT_SALE')), 'id')->getName()}'.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD_ON_TRANSPORT')), 'id')->getName()}'.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD_REPAIR')), 'id')->getName()}'.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_SOLD')), 'id')->getName()}'.</li>
                                                    <li>'{$this->vehicleStatusCollection->getByProperty(intval(ConstantsJsonFile::getValue('CARSTATUS_ON_TRANSPORT_WORKSHOP')), 'id')->getName()}'.</li>
                                                </ul>
                                ";
                    }
                }
            }
        }
    }

    private function updateVehicles(): void
    {
        foreach ($this->excelBody as $vehicleData) {
            try {
                $vehicle = null;
                $filterCollection = new FilterCollection([]);

                if (isset($vehicleData[VehicleExcelConstants::LICENSE_PLATE])) {
                    /**
                     * @var VehicleToUpdate $vehicleToUpdate
                     */
                    $vehicleToUpdate = $this->vehicleCollection->getByProperty($vehicleData[VehicleExcelConstants::LICENSE_PLATE], 'licensePlate');

                    $filterCollection->add(new Filter('LICENSEPLATE', new FilterOperator(FilterOperator::EQUAL), $vehicleToUpdate->getLicensePlate()));
                    /**
                     * @var Vehicle $vehicle
                     */
                    $vehicle = $this->vehicleRepository->getBy(new VehicleCriteria($filterCollection))->getCollection()[0];
                } elseif (isset($vehicleData[VehicleExcelConstants::VIN])) {
                    /**
                     * @var VehicleToUpdate $vehicleToUpdate
                     */
                    $vehicleToUpdate = $this->vehicleCollection->getByProperty($vehicleData[VehicleExcelConstants::VIN], 'vin');

                    $filterCollection->add(new Filter('VIN', new FilterOperator(FilterOperator::EQUAL), $vehicleToUpdate->getVin()));
                    /**
                     * @var Vehicle $vehicle
                     */
                    $vehicle = $this->vehicleRepository->getBy(new VehicleCriteria($filterCollection))->getCollection()[0];
                }


                if (isset($vehicleData[VehicleExcelConstants::STATUS]) && !is_null($vehicleData[VehicleExcelConstants::STATUS])) {
                    $vehicle->setStatus(new DomainVehicleStatus($vehicleData[VehicleExcelConstants::STATUS]->getId(), $vehicleData[VehicleExcelConstants::STATUS]->getName()));
                }

                if (isset($vehicleData[VehicleExcelConstants::LOCATION]) && !is_null($vehicleData[VehicleExcelConstants::LOCATION])) {
                    $vehicle->setLocation(new DomainLocation($vehicleData[VehicleExcelConstants::LOCATION]->getId(), $vehicleData[VehicleExcelConstants::LOCATION]->getName()));
                }

                if (isset($vehicleData[VehicleExcelConstants::RENTING_INIT_DATE]) && !is_null($vehicleData[VehicleExcelConstants::RENTING_INIT_DATE])) {
                    $vehicle->setFirstRentDate(new DateTimeValueObject($vehicleData[VehicleExcelConstants::RENTING_INIT_DATE]));
                }

                if (isset($vehicleData[VehicleExcelConstants::RENTING_END_DATE]) && !is_null($vehicleData[VehicleExcelConstants::RENTING_END_DATE])) {
                    $vehicle->setRentingEndDate(new DateTimeValueObject($vehicleData[VehicleExcelConstants::RENTING_END_DATE]));
                }

                if (isset($vehicleData[VehicleExcelConstants::CHECK_IN_DATE]) && !is_null($vehicleData[VehicleExcelConstants::CHECK_IN_DATE])) {
                    $vehicle->setReturnDate(new DateTimeValueObject($vehicleData[VehicleExcelConstants::CHECK_IN_DATE]));
                }

                if (isset($vehicleData[VehicleExcelConstants::DATE_BLOCKAGE_START]) && !is_null($vehicleData[VehicleExcelConstants::DATE_BLOCKAGE_START])) {
                    $vehicle->setInitBlockageDate(new DateValueObject($vehicleData[VehicleExcelConstants::DATE_BLOCKAGE_START]));
                }

                if (isset($vehicleData[VehicleExcelConstants::DATE_BLOCKAGE_END]) && !is_null($vehicleData[VehicleExcelConstants::DATE_BLOCKAGE_END])) {
                    $vehicle->setEndBlockageDate(new DateValueObject($vehicleData[VehicleExcelConstants::DATE_BLOCKAGE_END]));
                }

                if (isset($vehicleData[VehicleExcelConstants::BLOCKAGE_COMMENTS]) && $vehicleData[VehicleExcelConstants::BLOCKAGE_COMMENTS] !== '') {
                    $vehicle->setBlockageReason($vehicleData[VehicleExcelConstants::BLOCKAGE_COMMENTS]);
                }

                $updated = $this->vehicleRepository->update($vehicle);
                if ($updated) $this->managedVehicles['updated'][] = "{$vehicle->getLicensePlate()} / {$vehicle->getVin()}";
            } catch (Exception $e) {
                $this->managedVehicles['notUpdated'][] = "Error en la actualización de datos del vehículo con matrícula '{$vehicle->getLicensePlate()}' y bastidor '{$vehicle->getVin()}'. <br>Motivo: {$e->getMessage()}";
            }
        }
    }


    private function verifyDateValid(string $column, int $value): ?DateTime
    {
        $date = (new DateTime())->setTimestamp($value);
        if (!$date) {
            $this->excelErrors[] = sprintf("La %s '%s' no es una fecha correcta", strtolower(VehicleExcelConstants::getTitle($column)), $value);
            return null;
        } else {
            return $date;
        }
    }

    private function checkVehicleStatus($value, string $field, bool $sendError = true): ?VehicleStatus
    {
        try {
            return $this->vehicleStatusCollection->getByProperty($value, $field);
        } catch (\Exception $e) {
            if ($sendError) $this->excelErrors[] = sprintf("El %s del vehículo con ID/nombre '%s' no existe en el sístema.", strtolower(VehicleExcelConstants::TITLE_STATUS), strval($value));
            return null;
        }
    }

    private function checkLocation($value, string $field, bool $sendError = true): ?Location
    {
        try {
            return $this->locationCollection->getByProperty($value, $field);
        } catch (\Exception $e) {
            if ($sendError) $this->excelErrors[] = sprintf("La %s del vehículo con ID/nombre '%s' no existe en el sístema.", strtolower(VehicleExcelConstants::TITLE_LOCATION), strval($value));
            return null;
        }
    }




    // FUNCIONES PARA CSV, no eliminar por si se solicita de nuevo
    /**
     * Comprobación de los datos introducidos en el archivo excel (CSV)
     *
     * @param SplFileInfo $file
     * @return array
     */
    // private function checkExcelFile(SplFileInfo $file): array
    // {
    //     $countHeaders = 0;
    //     $headers = [];
    //     $updateData = [];

    //     $fp = fopen($file->getRealPath(), 'rb');

    //     while ($row = fgetcsv($fp, 1000, ';')) {
    //         if ($countHeaders === 0) {
    //             $headers = $this->checkHeaders($row);
    //             if (count($headers) === 0 || count($this->excelErrors) > 0) {
    //                 break;
    //             }
    //         } else {
    //             $body = $this->checkBody($row, $headers, $countHeaders);

    //             if (count($body) === 0) {
    //                 break;
    //             }

    //             $updateData[] = $body;
    //         }

    //         $countHeaders++;
    //     }

    //     fclose($fp);

    //     if ($countHeaders == 1) {
    //         $this->excelErrors[] = "No se han introducido datos de vehículos.";
    //     }
    //     if (count($headers) === 0) {
    //         $this->excelErrors[] = 'El archivo excel (CSV) no puede estar vacío.';
    //     }

    //     return $updateData;
    // }

    // private function checkHeaders(array $headers): array
    // {
    //     $finalHeaders = [];
    //     // Primero eliminamos caracreteres especiales y comillas
    //     $headers = array_map(function ($value) {
    //         return str_replace("\"", '', str_replace("\xEF\xBB\xBF", '', $value));
    //     }, $headers);

    //     // Luego filtramos campos vacíos y nulos. Si no se hace así, array_filter devuelve un array con un string vacío.
    //     $headers = array_filter($headers, function ($value) {
    //         return $value !== "" && !is_null($value);
    //     });

    //     foreach ($headers as $position => $headerName) {
    //         if (!in_array($headerName, $this->headers, true)) {
    //             $this->excelErrors[] = "La columna '$headerName' no es correcta";
    //         } else if (array_search($headerName, $this->headers, true) !== $position) {
    //             $this->excelErrors[] = "La columna '$headerName' no se puede cambiar de posición";
    //         }

    //         $finalHeaders[] = VehicleExcelConstants::getHeader($headerName);
    //     }

    //     $requiredHeaders = [
    //         VehicleExcelConstants::TITLE_LICENSE_PLATE,
    //         VehicleExcelConstants::TITLE_VIN,
    //     ];

    //     foreach ($requiredHeaders as $field) {
    //         if (!in_array($field, $headers, true)) {
    //             $this->excelErrors[] = sprintf('Las siguientes columnas son obligatorias: %s', implode(', ', array_map(function ($header) {
    //                 return "'$header'";
    //             }, $requiredHeaders)));
    //             break;
    //         }
    //     }

    //     return $finalHeaders;
    // }

    // private function checkBody($row, $headers, $countHeaders): array
    // {
    //     $dataColumn = [];
    //     $vehicleStatus = null;

    //     foreach ($headers as $key => $head) {
    //         if ($row[$key] !== '') {
    //             $dataColumn[$head] = trim($row[$key]);
    //         }
    //     }

    //     // Matrícula y bastidor
    //     if (!array_key_exists(VehicleExcelConstants::LICENSE_PLATE, $dataColumn) && !array_key_exists(VehicleExcelConstants::VIN, $dataColumn)) {
    //         $this->excelErrors[] = sprintf('Debes insertar la %s o el %s del vehículo en la fila %d', strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE), strtolower(VehicleExcelConstants::TITLE_VIN), ($countHeaders + 1));
    //     } elseif ((!array_key_exists(VehicleExcelConstants::LICENSE_PLATE, $dataColumn) || !array_key_exists(VehicleExcelConstants::VIN, $dataColumn)) && (count($dataColumn) < 2)) {
    //         $this->excelErrors[] = sprintf('Debes insertar la %s y/o el %s del vehículo, y otro campo como mínimo en la fila %d', strtolower(VehicleExcelConstants::TITLE_LICENSE_PLATE), strtolower(VehicleExcelConstants::TITLE_VIN), ($countHeaders + 1));
    //     }

    //     // Estado
    //     if (array_key_exists(VehicleExcelConstants::STATUS, $dataColumn)) {
    //         $vehicleStatus = (is_numeric($dataColumn[VehicleExcelConstants::STATUS])) ?
    //             $this->checkVehicleStatus(intval($dataColumn[VehicleExcelConstants::STATUS]), 'id', false)
    //             : $this->checkVehicleStatus($dataColumn[VehicleExcelConstants::STATUS], 'name', false);
    //         if (is_null($vehicleStatus)) $this->excelErrors[] = sprintf('El %s del vehículo insertado en la fila %d no es correcto', strtolower(VehicleExcelConstants::TITLE_STATUS), ($countHeaders + 1));
    //     }

    //     // Fechas alquiler
    //     if (array_key_exists(VehicleExcelConstants::RENTING_INIT_DATE, $dataColumn) && array_key_exists(VehicleExcelConstants::RENTING_END_DATE, $dataColumn)) {
    //         if (strtotime(str_replace('/', '-', $dataColumn[VehicleExcelConstants::RENTING_INIT_DATE])) > strtotime(str_replace('/', '-', $dataColumn[VehicleExcelConstants::RENTING_END_DATE]))) {
    //             $this->excelErrors[] = sprintf('La %s es mayor a la %s en la fila %d', strtolower(VehicleExcelConstants::TITLE_RENTING_INIT_DATE), strtolower(VehicleExcelConstants::TITLE_RENTING_END_DATE), ($countHeaders + 1));
    //         }
    //     }

    //     // Fechas bloqueo
    //     if (
    //         (array_key_exists(VehicleExcelConstants::DATE_BLOCKAGE_START, $dataColumn) && !array_key_exists(VehicleExcelConstants::DATE_BLOCKAGE_END, $dataColumn)) ||
    //         (array_key_exists(VehicleExcelConstants::DATE_BLOCKAGE_END, $dataColumn) && !array_key_exists(VehicleExcelConstants::DATE_BLOCKAGE_START, $dataColumn))
    //     ) {
    //         $this->excelErrors[] = sprintf('Debes insertar ambas fechas de inicio y fin de bloqueo en la fila %d', ($countHeaders + 1));
    //     }
    //     if (array_key_exists(VehicleExcelConstants::DATE_BLOCKAGE_START, $dataColumn) && array_key_exists(VehicleExcelConstants::DATE_BLOCKAGE_END, $dataColumn)) {
    //         if (strtotime(str_replace('/', '-', $dataColumn[VehicleExcelConstants::DATE_BLOCKAGE_START])) > strtotime(str_replace('/', '-', $dataColumn[VehicleExcelConstants::DATE_BLOCKAGE_END]))) {
    //             $this->excelErrors[] = sprintf('La %s es mayor a la %s en la fila %d', strtolower(VehicleExcelConstants::TITLE_DATE_BLOCKAGE_START), strtolower(VehicleExcelConstants::TITLE_DATE_BLOCKAGE_END), ($countHeaders + 1));
    //         }
    //     }
    //     if (array_key_exists(VehicleExcelConstants::DATE_BLOCKAGE_START, $dataColumn) && array_key_exists(VehicleExcelConstants::DATE_BLOCKAGE_END, $dataColumn) && !array_key_exists(VehicleExcelConstants::BLOCKAGE_COMMENTS, $dataColumn)) {
    //         $this->excelErrors[] = sprintf('Debes insertar un %s en la fila %d', strtolower(VehicleExcelConstants::TITLE_BLOCKAGE_COMMENTS), ($countHeaders + 1));
    //     }

    //     // Fecha devolución
    //     if (array_key_exists(VehicleExcelConstants::RENTING_END_DATE, $dataColumn) && array_key_exists(VehicleExcelConstants::CHECK_IN_DATE, $dataColumn)) {
    //         if (strtotime(str_replace('/', '-', $dataColumn[VehicleExcelConstants::RENTING_END_DATE])) > strtotime(str_replace('/', '-', $dataColumn[VehicleExcelConstants::CHECK_IN_DATE]))) {
    //             $this->excelErrors[] = sprintf('La %s es mayor a la %s en la fila %d', VehicleExcelConstants::TITLE_RENTING_END_DATE, VehicleExcelConstants::TITLE_CHECK_IN_DATE, ($countHeaders + 1));
    //         }
    //     }


    //     if (!empty($dataColumn[VehicleExcelConstants::LICENSE_PLATE]) || !empty($dataColumn[VehicleExcelConstants::VIN])) {
    //         foreach ($dataColumn as $column => $value) {
    //             switch ($column) {
    //                 case VehicleExcelConstants::STATUS:
    //                     $dataColumn[$column] = $vehicleStatus;
    //                     break;
    //                 case VehicleExcelConstants::RENTING_INIT_DATE:
    //                 case VehicleExcelConstants::RENTING_END_DATE:
    //                 case VehicleExcelConstants::CHECK_IN_DATE:
    //                 case VehicleExcelConstants::DATE_BLOCKAGE_START:
    //                 case VehicleExcelConstants::DATE_BLOCKAGE_END:
    //                     $dataColumn[$column] = $this->verifyDateValid($column, $value);
    //                     break;
    //                 case VehicleExcelConstants::BLOCKAGE_COMMENTS:
    //                     $dataColumn[$column] = ((preg_match('//u', $row[8]) !== 1) ? iconv('ISO-8859-1', 'UTF-8', $value) : $value);
    //                     break;
    //             }
    //         }
    //     }

    //     return $dataColumn;
    // }

}
