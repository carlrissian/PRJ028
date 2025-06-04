<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterMovement;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Distribution\Movement\Domain\Movement;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Movement\Domain\DeliveryNote;
use Distribution\Movement\Domain\VehicleFilter;
use Distribution\Movement\Domain\MovementCriteria;
use Distribution\Movement\Domain\MovementException;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\Movement\Domain\MovementVehicleLine;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Distribution\Movement\Domain\MovementVehicleLineCollection;
use Distribution\Movement\Domain\VehicleLine;

class FilterMovementQueryHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * FilterMovementQueryHandler constructor.
     *
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param FilterMovementQuery $query
     * @param boolean $excel
     * @param string|null $type
     * @return FilterMovementResponse
     *
     * @throws MovementException
     */
    final public function handle(FilterMovementQuery $query, bool $excel = false, string $type = null): FilterMovementResponse
    {
        $movementTypeId = $query->getMovementTypeId();

        $criteria = $this->setGetByCriteria($query);
        [$movementCollection, $totalRows] = $this->movementRepository->getBy($criteria)->toArray();

        //Se obtienen los vehículos según IDS de los movimientos
        $movementIds = array_map(function ($movement) {
            return $movement->getId();
        }, $movementCollection->toArray());

        $vehicleFilterCriteria = $this->setGetByVehiclesCriteria($movementIds);

        /**
         * @var MovementVehicleLineCollection $vehicleLineCollection
         */
        [$movementVehicleLineCollection, $totalRowsLines] = $this->movementRepository->getByVehicles($vehicleFilterCriteria)->toArray();


        $movementList = [];

        /**
         * @var Movement $movement
         */
        foreach ($movementCollection as $movement) {
            [
                $vehicle,
                $driverName,
                $deliveryNotes,
                $assignedLicensePlateUnits,
                $manualOriginLocation,
                $manualDestinationLocation,
                $originBranch,
                $destinationBranch,
                $originBranchName,
                $destinationBranchName,
                $actualLoadDate,
                $actualUnloadDate,
                $firstActualLoadDate,
                $firstActualUnloadDate,
                $lastActualLoadDate,
                $lastActualUnloadDate,
            ] = null;
            [
                $pendingAssignedError,
                $pendingExpectedLoadError,
                $pendingExpectedUnloadError,
                $pendingVehicleFilterError,
            ] = false;

            /**
             * DRIVER
             */
            if ($movementTypeId === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_DRIVER')) && $movementVehicleLineCollection->count() > 0) {
                foreach ($movementVehicleLineCollection as $movementVehicleLine) {
                    /**
                     * @var MovementVehicleLine $movementVehicleLine
                     */
                    if ($movementVehicleLine->getMovementId() == $movement->getId()) {
                        /**
                         * @var VehicleLine $vehicleLine
                         */
                        $vehicleLine = $movementVehicleLine->getVehicleLines()[0];

                        $vehicle = [
                            'id' => $vehicleLine->getVehicle()->getId(),
                            'licensePlate' => $vehicleLine->getVehicle()->getLicensePlate(),
                            'brandName' => $vehicleLine->getVehicle()->getBrand()->getName(),
                            'modelName' => $vehicleLine->getVehicle()->getModel()->getName(),
                            'kilometers' => $vehicleLine->getVehicle()->getActualKms(),
                            'tankCapacity' => $vehicleLine->getVehicle()->getTankCapacity(),
                            'batteryCapacity' => $vehicleLine->getVehicle()->getBatteryCapacity()
                        ];

                        $actualLoadDate = $vehicleLine->getActualLoadDate();
                        $actualUnloadDate = $vehicleLine->getActualUnloadDate();
                    }
                }


                // Si localización origen es 'Otros'
                if (!empty($movement->getManualOriginLocation())) {
                    $manualOriginLocation = [
                        'state' => $movement->getManualOriginLocation()->getState(),
                        'country' => $movement->getManualOriginLocation()->getCountry(),
                        'notes' => $movement->getManualOriginLocation()->getNotes(),
                    ];
                }

                // Si localización destino es 'Otros'
                if (!empty($movement->getManualDestinationLocation())) {
                    $manualDestinationLocation = [
                        'state' => $movement->getManualDestinationLocation()->getState(),
                        'country' => $movement->getManualDestinationLocation()->getCountry(),
                        'notes' => $movement->getManualDestinationLocation()->getNotes(),
                    ];
                }

                $driverName = $movement->getDriver() ? $movement->getDriver()->getName() : null;
            }

            /**
             * CARRIER
             */
            if ($movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER')) && $movement->getDeliveryNoteCollection()) {
                $deliveryNotes = [];

                /**
                 * @var DeliveryNote $deliveryNote
                 */
                foreach ($movement->getDeliveryNoteCollection() as $deliveryNote) {
                    $deliveryNotes[] = [
                        'id' => $deliveryNote->getId(),
                        'typeId' => $deliveryNote->getTypeId(),
                        'typeName' => $deliveryNote->getTypeName(),
                        'file' => $deliveryNote->getFile(),
                        'uploadDate' => $deliveryNote->getDateUpload(),
                        'uploadUser' => $deliveryNote->getUser() ? [
                            'id' => $deliveryNote->getUser()->getId(),
                            'name' => $deliveryNote->getUser()->getName(),
                        ] : null,
                    ];
                }
            }

            /**
             * CARRIER, OPERATION
             */
            if (in_array($movement->getMovementType()->getId(), [(int) ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'),  (int) ConstantsJsonFile::getValue('TRANSPORTTYPE_OPERATION')])) {
                $vehicle = [];

                /**
                 * @var MovementVehicleLine $movementVehicleLine
                 */
                foreach ($movementVehicleLineCollection as $movementVehicleLine) {
                    if ($movementVehicleLine->getMovementId() === $movement->getId()) {
                        foreach ($movementVehicleLine->getVehicleLines() as $vehicleLine) {
                            $vehicle[] = [
                                'id' => $vehicleLine->getVehicle()->getId(),
                                'brandName' => $vehicleLine->getVehicle()->getBrand() ? $vehicleLine->getVehicle()->getBrand()->getName() : null,
                                'modelName' => $vehicleLine->getVehicle()->getModel() ? $vehicleLine->getVehicle()->getModel()->getName() : null,
                                'carGroupName' => $vehicleLine->getVehicle()->getCarGroup() ? $vehicleLine->getVehicle()->getCarGroup()->getName() : null,
                                'licensePlate' => $vehicleLine->getVehicle()->getLicensePlate(),
                                'vin' => $vehicleLine->getVehicle()->getVin(),
                                'kilometersActualLoad' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getKilometersActual() : null,
                                'batteryActualLoad' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getBatteryActual() : null,
                                'kilometersActualUnload' => $vehicleLine->getVehicleRecordsUnload() ? $vehicleLine->getVehicleRecordsUnload()->getKilometersActual() : null,
                                'batteryActualUnload' => $vehicleLine->getVehicleRecordsUnload() ? $vehicleLine->getVehicleRecordsUnload()->getBatteryActual() : null,
                                'vehicleStatus' => $vehicleLine->getVehicle()->getStatus() ? $vehicleLine->getVehicle()->getStatus()->getName() : null,
                                'saleBlockDate' => $vehicleLine->getVehicle()->getInitBlockDate(),
                                'vehicleConnected' => $vehicleLine->getVehicle()->isConnected(),
                                'checkInDueDate' => $vehicleLine->getVehicle()->getRentingEndDate(),
                                'resaleCode' => $vehicleLine->getVehicle()->getSaleMethod() ? $vehicleLine->getVehicle()->getSaleMethod()->getName() : null,
                                'dateBlockage' => $vehicleLine->getVehicle()->getInitBlockDate(),
                                'dateBlockageEnd' => $vehicleLine->getVehicle()->getEndBlockDate(),
                                'actualLoadDate' => $vehicleLine->getActualLoadDate(),
                                'actualUnloadDate' => $vehicleLine->getActualUnloadDate(),
                                'vehicleMaintenanceEndDate' => $vehicleLine->getVehicleMaintenanceEndDate(),
                            ];
                        }

                        // Recolección de fecha de carga/descarga más reciente y más antigua
                        if ($movementVehicleLine->getVehicleLines() && $movementVehicleLine->getVehicleLines()->count() > 0) {
                            $activeLines = array_filter($movementVehicleLine->getVehicleLines()->toArray(), function ($line) {
                                return $line->getVehicleDelete() === null && ($line->getActualLoadDate() !== null || $line->getActualUnloadDate() !== null);
                            });

                            if (count($activeLines) > 0) {
                                // Fechas de carga
                                $loadDates = array_filter(array_map(function ($line) {
                                    return $line->getActualLoadDate();
                                }, $activeLines), function ($date) {
                                    return $date !== null;
                                });
                                // Fecha de carga antigua
                                $firstActualLoadDate = array_filter($loadDates, function ($date) use ($loadDates) {
                                    return $date->getValue() === min(array_map(function ($date) {
                                        return $date->getValue();
                                    }, $loadDates));
                                });
                                $firstActualLoadDate = reset($firstActualLoadDate) ?: null;
                                // Fecha de carga reciente
                                $lastActualLoadDate = array_filter($loadDates, function ($date) use ($loadDates) {
                                    return $date->getValue() === max(array_map(function ($date) {
                                        return $date->getValue();
                                    }, $loadDates));
                                });
                                $lastActualLoadDate = reset($lastActualLoadDate) ?: null;

                                // Fechas de descarga
                                $unloadDates = array_filter(array_map(function ($line) {
                                    return $line->getActualUnloadDate();
                                }, $activeLines), function ($date) {
                                    return $date !== null;
                                });
                                // Fecha de descarga antigua
                                $firstActualUnloadDate = array_filter($unloadDates, function ($date) use ($unloadDates) {
                                    return $date->getValue() === min(array_map(function ($date) {
                                        return $date->getValue();
                                    }, $unloadDates));
                                });
                                $firstActualUnloadDate = reset($firstActualUnloadDate) ?: null;
                                // Fecha de descarga reciente
                                $lastActualUnloadDate = array_filter($unloadDates, function ($date) use ($unloadDates) {
                                    return $date->getValue() === max(array_map(function ($date) {
                                        return $date->getValue();
                                    }, $unloadDates));
                                });
                                $lastActualUnloadDate = reset($lastActualUnloadDate) ?: null;
                            }
                        }
                    }
                }

                $assignedLicensePlateUnits = [
                    'total' => $movement->getAssignedLicensePlateUnits()->getTotal(),
                    'load' => $movement->getAssignedLicensePlateUnits()->getLoad(),
                    'unload' => $movement->getAssignedLicensePlateUnits()->getUnload()
                ];

                // COMPROBAR SI SE CUMPLEN LOS REQUISITOS PARA MOSTRAR ESTADO PENDIENTE EN ROJO.
                if ($movement->getMovementStatus()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTSTATUS_PENDING'))) {
                    $date_now = time();

                    // Si no hay vehiculos asignados
                    $pendingAssignedError = $movement->getAssignedLicensePlateUnits()->getTotal() === 0;
                    // Si fecha prevista carga es posterior a fecha actual y no existe fecha actual de carga
                    $pendingExpectedLoadError = ($movement->getExpectedLoadDate() && $date_now < strtotime($movement->getExpectedLoadDate()->__toString())) && $lastActualLoadDate == null;
                    // Si fecha prevista descarga es anterior a fecha actual y no existe fecha actual de descarga
                    $pendingExpectedUnloadError = ($movement->getExpectedUnloadDate() && $date_now > strtotime($movement->getExpectedUnloadDate()->__toString())) && $lastActualUnloadDate == null;

                    /**
                     * Si los vehículos asignados cumples los requisitos de los filtros del movimiento
                     * @var VehicleFilter $vehicleFilter
                     */
                    // foreach ($movement->getVehicleFilterCollection() as $vehicleFilter) {
                    //     foreach ($movement->getVehicleLineCollection() as $vehicleLine) {
                    //         if (!in_array($vehicleLine->getVehicle()->getType(), $vehicleFilter->getVehicleTypeCollection()->toArray())) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //         if (!in_array($vehicleLine->getVehicle()->getBrand(), $vehicleFilter->getBrandCollection()->toArray())) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //         if (!in_array($vehicleLine->getVehicle()->getModel(), $vehicleFilter->getModelCollection()->toArray())) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //         if (!in_array($vehicleLine->getVehicle()->getCarGroup(), $vehicleFilter->getCarGroupCollection()->toArray())) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //         if ($vehicleLine->getVehicle()->getActualKms() < $vehicleFilter->getKilometersFrom() || $vehicleLine->getVehicle()->getActualKms() > $vehicleFilter->getKilometersTo()) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //         if ($vehicleLine->getVehicle()->getRentingEndDate() < $vehicleFilter->getRentingEndDateFrom() || $vehicleLine->getVehicle()->getActualKms() > $vehicleFilter->getKilometersTo()) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //         if (!in_array($vehicleLine->getVehicle()->getStatus(), $vehicleFilter->getVehicleStatusCollection()->toArray())) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //         if (!in_array($vehicleLine->getVehicle()->getSaleMethod(), $vehicleFilter->getSaleMethodCollection()->toArray())) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //         if (!$vehicleLine->getVehicle()->isConnected() !== $vehicleFilter->isConnectedVehicle()) {
                    //             $pendingVehicleFilterError = true;
                    //         }
                    //     }
                    // }
                }
            }

            // Origin branch
            if (!empty($movement->getOriginLocation()) && !empty($movement->getOriginLocation()->getBranch())) {
                $originBranch = [
                    'id' => $movement->getOriginLocation()->getBranch()->getId(),
                    'name' => $movement->getOriginLocation()->getBranch()->getName(),
                    'branchIATA' => $movement->getOriginLocation()->getBranch()->getBranchIATA() ?? null,
                ];
                // Campo para excel
                $originBranchName = $movement->getOriginLocation()->getBranch()->getName();
            } else if (!empty($movement->getOriginExternalLocation()) && !empty($movement->getOriginExternalLocation()->getBranch())) {
                $originBranch = [
                    'id' => $movement->getOriginExternalLocation()->getBranch()->getId(),
                    'name' => $movement->getOriginExternalLocation()->getBranch()->getName(),
                    'branchIATA' => $movement->getOriginExternalLocation()->getBranch()->getBranchIATA() ?? null,
                ];
                // Campo para excel
                $originBranchName = $movement->getOriginExternalLocation()->getBranch()->getName();
            } else if (!empty($movement->getOriginBranch())) {
                $originBranch = [
                    'id' => $movement->getOriginBranch()->getId(),
                    'name' => $movement->getOriginBranch()->getName(),
                    'branchIATA' => $movement->getOriginBranch()->getBranchIATA() ?? null,
                ];
                // Campo para excel
                $originBranchName = $movement->getOriginBranch()->getName();
            }

            // Destination branch
            if (!empty($movement->getDestinationLocation()) && !empty($movement->getDestinationLocation()->getBranch())) {
                $destinationBranch = [
                    'id' => $movement->getDestinationLocation()->getBranch()->getId(),
                    'name' => $movement->getDestinationLocation()->getBranch()->getName(),
                    'branchIATA' => $movement->getDestinationLocation()->getBranch()->getBranchIATA() ?? '',
                ];
                // Campo para excel
                $destinationBranchName = $movement->getDestinationLocation()->getBranch()->getName();
            } else if (!empty($movement->getDestinationExternalLocation()) && !empty($movement->getDestinationExternalLocation()->getBranch())) {
                $destinationBranch = [
                    'id' => $movement->getDestinationExternalLocation()->getBranch()->getId(),
                    'name' => $movement->getDestinationExternalLocation()->getBranch()->getName(),
                    'branchIATA' => $movement->getDestinationExternalLocation()->getBranch()->getBranchIATA() ?? '',
                ];
                // Campo para excel
                $destinationBranchName = $movement->getDestinationExternalLocation()->getBranch()->getName();
            } else if (!empty($movement->getDestinationBranch())) {
                $destinationBranch = [
                    'id' => $movement->getDestinationBranch()->getId(),
                    'name' => $movement->getDestinationBranch()->getName(),
                    'branchIATA' => $movement->getDestinationBranch()->getBranchIATA() ?? null,
                ];
                // Campo para excel
                $destinationBranchName = $movement->getDestinationBranch()->getName();
            }


            // FIXME muchas de las tienen nombres ambiguos o incorrectos.
            $movementList[] = [
                'id' => $movement->getId(),
                'orderNumber' => $movement->getOrderNumber(),
                'movementCategoryId' => $movement->getMovementCategory() ? $movement->getMovementCategory()->getId() : null,
                'movementCategoryName' => $movement->getMovementCategory() ? $movement->getMovementCategory()->getName() : null,
                'movementTypeName' => $movement->getMovementType()->getName(),
                'movementStatus' => $movement->getMovementStatus() ? [
                    'id' => $movement->getMovementStatus()->getId(),
                    'name' => $movement->getMovementStatus()->getName(),
                ] : null,
                // Campo exclusivo para modal validación de movimiento
                'movementStatusId' => $movement->getMovementStatus()->getId(),
                'driverTypeName' => $movement->isExtTransport() ? 'provider' : 'employee',
                'businessUnitName' => $movement->getBusinessUnit() ? $movement->getBusinessUnit()->getName() : null,
                'businessUnitArticleName' => $movement->getBusinessUnitArticle() ? $movement->getBusinessUnitArticle()->getName() : null,
                'supplierName' => ($movement->getSupplier()) ? $movement->getSupplier()->getName() : null,
                'driverName' => $driverName,
                'automaticCost' => $movement->getAutomaticCost(),
                'manualCost' => $movement->getManualCost(),

                'expectedLoadDate' => $movement->getExpectedLoadDate(),
                'actualLoadDate' => $actualLoadDate,
                'firstActualLoadDate' => $firstActualLoadDate,
                'lastActualLoadDate' => $lastActualLoadDate,
                'expectedUnloadDate' => $movement->getExpectedUnloadDate(),
                'actualUnloadDate' => $actualUnloadDate,
                'firstActualUnloadDate' => $firstActualUnloadDate,
                'lastActualUnloadDate' => $lastActualUnloadDate,

                'originLocation' => $movement->getOriginLocation() ? $movement->getOriginLocation()->getName() : null,
                'externalOriginLocation' => $movement->getOriginExternalLocation() ? $movement->getOriginExternalLocation()->getName() : null,
                'manualOriginLocation' => $manualOriginLocation,
                'originBranch' => $originBranch,
                'originBranchName' => $originBranchName,

                'destinationLocation' => $movement->getDestinationLocation() ? $movement->getDestinationLocation()->getName() : null,
                'externalDestinationLocation' => $movement->getDestinationExternalLocation() ? $movement->getDestinationExternalLocation()->getName() : null,
                'manualDestinationLocation' => $manualDestinationLocation,
                'destinationBranch' => $destinationBranch,
                'destinationBranchName' => $destinationBranchName,

                'vehicle' => $vehicle,
                'deliveryNotes' => $deliveryNotes,
                'assignedLicensePlateUnits' => $assignedLicensePlateUnits,
                'vehicleUnits' => $movement->getVehicleUnits(),
                'transportMethodId' => $movement->getTransportMethod() ? $movement->getTransportMethod()->getId() : null,
                'department' => $movement->getDepartment() ? $movement->getDepartment()->getName() : null,

                'pendingAssignedError' => $pendingAssignedError,
                'pendingExpectedLoadError' => $pendingExpectedLoadError,
                'pendingExpectedUnloadError' => $pendingExpectedUnloadError,
                'pendingVehicleFilterError' => $pendingVehicleFilterError,

                'creationUser' => $movement->getCreationUser() ? [
                    'id' => $movement->getCreationUser()->getId(),
                    'name' => $movement->getCreationUser()->getName(),
                ] : null,
                'creationDate' => $movement->getCreationDate(),
            ];
        }


        if ($excel && $type == 'movement') {
            $body = $this->createMovementExcelArrayFormatter($movementList, $movementTypeId);
            $movementResponse['total'] = count($body);
            $movementResponse['rows'] = $body;
        } else if ($excel && $type == 'vehicle') {
            $vehicle = $this->createVehicleExcelArrayFormatter($movementList);
            $movementResponse['total'] = count($vehicle);
            $movementResponse['rows'] = $vehicle;
        } else {
            $movementResponse['total'] = $totalRows;
            $movementResponse['rows'] = $movementList;
        }

        return new FilterMovementResponse($movementResponse);
    }


    /**
     * @param FilterMovementQuery $query
     * @return MovementCriteria
     */
    private function setGetByCriteria(FilterMovementQuery $query): MovementCriteria
    {
        $sortCollection = null;
        $filterCollection = new FilterCollection([]);

        if ($query->getMovementCategory()) $filterCollection->add(new Filter('TRANSPORTCATIDIN', new FilterOperator(FilterOperator::IN), $query->getMovementCategory()));

        if ($query->getMovementTypeId()) $filterCollection->add(new Filter('TRANSPORTTYPEID', new FilterOperator(FilterOperator::EQUAL), $query->getMovementTypeId()));

        if ($query->getExtTransport() !== null) $filterCollection->add(new Filter('EXTTRANSPORT', new FilterOperator(FilterOperator::EQUAL), $query->getExtTransport() ? 1 : 0));

        if ($query->getMovementStatusId()) $filterCollection->add(new Filter('TRANSPORTSTATUSID', new FilterOperator(FilterOperator::IN), $query->getMovementStatusId()));

        if ($query->getId() && count($query->getId()) == 1) $filterCollection->add(new Filter('ID', new FilterOperator(FilterOperator::EQUAL), $query->getId()[0]));

        if ($query->getId() && count($query->getId()) > 1) $filterCollection->add(new Filter('IDIN', new FilterOperator(FilterOperator::IN), $query->getId()));

        if ($query->getOrderNumber() && count($query->getOrderNumber()) == 1) $filterCollection->add(new Filter('SAPPO', new FilterOperator(FilterOperator::EQUAL), $query->getOrderNumber()[0]));

        if ($query->getOrderNumber() && count($query->getOrderNumber()) > 1) $filterCollection->add(new Filter('ORDERNUMBERIN', new FilterOperator(FilterOperator::IN), $query->getOrderNumber()));

        if ($query->getLicensePlate()) $filterCollection->add(new Filter('LICENSEPLATE', new FilterOperator(FilterOperator::EQUAL), $query->getLicensePlate()));

        if ($query->getVin()) $filterCollection->add(new Filter('VIN', new FilterOperator(FilterOperator::EQUAL), $query->getVin()));

        if ($query->getBrandId()) $filterCollection->add(new Filter('BRANDIDIN', new FilterOperator(FilterOperator::IN), $query->getBrandId()));

        if ($query->getModelId()) $filterCollection->add(new Filter('MODELIDIN', new FilterOperator(FilterOperator::IN), $query->getModelId()));

        if ($query->getSupplierCode()) $filterCollection->add(new Filter('SUPPLIERCODEIN', new FilterOperator(FilterOperator::IN), $query->getSupplierCode()));

        if ($query->getOriginLocationId()) $filterCollection->add(new Filter('ORIGINLOCATIONID', new FilterOperator(FilterOperator::IN), $query->getOriginLocationId()));

        if ($query->getDestinationLocationId()) $filterCollection->add(new Filter('DESTINYLOCATIONID', new FilterOperator(FilterOperator::IN), $query->getDestinationLocationId()));

        if ($query->getOriginBranchId()) $filterCollection->add(new Filter('BRANCHORIGINIDS', new FilterOperator(FilterOperator::IN), $query->getOriginBranchId()));

        if ($query->getDestinationBranchId()) $filterCollection->add(new Filter('BRANCHDESTINATIONIDS', new FilterOperator(FilterOperator::IN), $query->getDestinationBranchId()));

        // if ($query->getCheckOutDateFrom()) $filterCollection->add(new Filter('ACTUALLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($query->getCheckOutDateFrom())));

        // if ($query->getCheckOutDateTo()) $filterCollection->add(new Filter('ACTUALLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatDateToLastMinuteDateTime($query->getCheckOutDateTo())));

        // if ($query->getExpectedLoadDate()) $filterCollection->add(new Filter('ESTIMATEDDEPARTURE', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($query->getExpectedLoadDate())));

        // if ($query->getExpectedUnloadDate()) $filterCollection->add(new Filter('ESTIMATEDARRIVAL', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatDateToLastMinuteDateTime($query->getExpectedUnloadDate())));

        // if ($query->getActualLoadDate()) $filterCollection->add(new Filter('LOADDATE', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), $query->getActualLoadDate()));

        // if ($query->getActualUnloadDate()) $filterCollection->add(new Filter('UNLOADDATE', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), $query->getActualUnloadDate()));

        if ($query->getExpectedLoadDateFrom()) $filterCollection->add(new Filter('EXPECTEDLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($query->getExpectedLoadDateFrom())));

        if ($query->getExpectedLoadDateTo()) $filterCollection->add(new Filter('EXPECTEDLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatDateToLastMinuteDateTime($query->getExpectedLoadDateTo())));

        if ($query->getExpectedUnloadDateFrom()) $filterCollection->add(new Filter('EXPECTEDUNLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($query->getExpectedUnloadDateFrom())));

        if ($query->getExpectedUnloadDateTo()) $filterCollection->add(new Filter('EXPECTEDUNLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatDateToLastMinuteDateTime($query->getExpectedUnloadDateTo())));

        if ($query->getActualLoadDateFrom()) $filterCollection->add(new Filter('ACTUALLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($query->getActualLoadDateFrom())));

        if ($query->getActualLoadDateTo()) $filterCollection->add(new Filter('ACTUALLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatDateToLastMinuteDateTime($query->getActualLoadDateTo())));

        if ($query->getActualUnloadDateFrom()) $filterCollection->add(new Filter('ACTUALUNLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($query->getActualUnloadDateFrom())));

        if ($query->getActualUnloadDateTo()) $filterCollection->add(new Filter('ACTUALUNLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatDateToLastMinuteDateTime($query->getActualUnloadDateTo())));

        if ($query->getBusinessUnitId()) $filterCollection->add(new Filter('BUSINESSUNITID', new FilterOperator(FilterOperator::IN), $query->getBusinessUnitId()));

        if ($query->getBusinessUnitArticleId()) $filterCollection->add(new Filter('TRANSSAPARTICLEID', new FilterOperator(FilterOperator::IN), $query->getBusinessUnitArticleId()));


        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);
        $criteria = new MovementCriteria($filterCollection, $pagination);

        return $criteria;
    }

    /**
     * @param array $movementIds
     * @return MovementCriteria
     */
    private function setGetByVehiclesCriteria(array $movementIds): MovementCriteria
    {
        $filterCollection = new FilterCollection([]);

        if ($movementIds && count($movementIds) > 0) $filterCollection->add(new Filter('IDIN', new FilterOperator(FilterOperator::IN), $movementIds));


        $criteria = new MovementCriteria($filterCollection);

        return $criteria;
    }

    private function createMovementExcelArrayFormatter(array $movementList, int $movementTypeId): array
    {
        $movementExcel = [];

        if ($movementTypeId === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_DRIVER'))) {
            $movementExcel[] = [
                'Nº de pedido',
                'Nª de movimiento',
                'Matrícula',
                'Marca',
                'Modelo',
                'Categoria de movimiento',
                'Tipo de conductor',
                'Proveedor',
                'Importe de movimiento',
                'Unidad de Negocio-Articulo',
                'Delegación origen',
                'Localización origen',
                'Delegación destino',
                'Localización destino',
                'Fecha salida',
                'Hora salida',
                'Fecha llegada prevista',
                'Fecha llegada real',
                'Hora llegada real',
                'Estado del movimiento',
                'Departamento',
                'Usuario creación',
                'Fecha creación',
                'Hora creación'
            ];

            foreach ($movementList as $key => $movement) {
                $movementExcel[] = [
                    $movement['orderNumber'],
                    $movement['id'],
                    $movement['vehicle']['licensePlate'],
                    $movement['vehicle']['brandName'],
                    $movement['vehicle']['modelName'],
                    $movement['movementCategoryName'],
                    $movement['driverTypeName'],
                    $movement['supplierName'],
                    $movement['manualCost'],
                    sprintf("%s/%s", $movement['businessUnitName'], $movement['businessUnitArticleName']),
                    $movement['originBranchName'],
                    $movement['originLocation'] ?? $movement['externalOriginLocation'] ?? sprintf('%s | %s', $movement['manualOriginLocation']['state']->getName(), $movement['manualOriginLocation']['country']->getName()),
                    $movement['destinationBranchName'],
                    $movement['destinationLocation'] ?? $movement['externalDestinationLocation'] ?? sprintf('%s | %s', $movement['manualDestinationLocation']['state']->getName(), $movement['manualDestinationLocation']['country']->getName()),
                    $movement['actualLoadDate'] ? $movement['actualLoadDate']->__toString("d/m/Y") : null,
                    $movement['actualLoadDate'] ? $movement['actualLoadDate']->__toString("H:i") : null,
                    $movement['expectedUnloadDate'],
                    $movement['actualUnloadDate'] ? $movement['actualUnloadDate']->__toString("d/m/Y") : null,
                    $movement['actualUnloadDate'] ? $movement['actualUnloadDate']->__toString("H:i") : null,
                    $movement['movementStatus']['name'],
                    $movement['department'],
                    $movement['creationUser']['name'],
                    $movement['creationDate'] ? $movement['creationDate']->__toString("d/m/Y") : null,
                    $movement['creationDate'] ? $movement['creationDate']->__toString("H:i") : null,
                ];
            }
        }
        if ($movementTypeId === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'))) {
            $movementExcel[] = [
                'Nª de movimiento',
                'Nª de pedido',
                'Estado del movimiento',
                'Unidades Negocio-Articulo',
                'Proveedor',
                'Unidades',
                'Importe',
                'Fecha prevista carga',
                'Fecha real carga',
                'Hora real carga',
                'Fecha prevista descarga',
                'Fecha real descarga',
                'Hora real descarga',
                'Localizacion origen',
                'Delegación origen',
                'Localizacion destino',
                'Delegación destino',
                'Usuario creacion',
                'Fecha creación',
                'Hora creación',
            ];

            foreach ($movementList as $key => $movement) {
                [$actualLoadDate, $actualLoadTime, $actualUnloadDate, $actualUnloadTime] = null;
                // Fecha/hora real carga
                if ($movement['actualLoadDate']) {
                    $actualLoadDate = $movement['actualLoadDate']->__toString("d/m/Y");
                    $actualLoadTime = $movement['actualLoadDate']->__toString("H:i");
                } else if ($movement['lastActualLoadDate']) {
                    $actualLoadDate = $movement['lastActualLoadDate']->__toString("d/m/Y");
                    $actualLoadTime = $movement['lastActualLoadDate']->__toString("H:i");
                } else if ($movement['firstActualLoadDate']) {
                    $actualLoadDate = $movement['firstActualLoadDate']->__toString("d/m/Y");
                    $actualLoadTime = $movement['firstActualLoadDate']->__toString("H:i");
                }
                // Fecha/hora real descarga
                if ($movement['actualUnloadDate']) {
                    $actualUnloadDate = $movement['actualUnloadDate']->__toString("d/m/Y");
                    $actualUnloadTime = $movement['actualUnloadDate']->__toString("H:i");
                } else if ($movement['lastActualUnloadDate']) {
                    $actualUnloadDate = $movement['lastActualUnloadDate']->__toString("d/m/Y");
                    $actualUnloadTime = $movement['lastActualUnloadDate']->__toString("H:i");
                } else if ($movement['firstActualUnloadDate']) {
                    $actualUnloadDate = $movement['firstActualUnloadDate']->__toString("d/m/Y");
                    $actualUnloadTime = $movement['firstActualUnloadDate']->__toString("H:i");
                }

                $movementExcel[] = [
                    $movement['id'],
                    $movement['orderNumber'],
                    $movement['movementStatus']['name'],
                    sprintf("%s/%s", $movement['businessUnitName'], $movement['businessUnitArticleName']),
                    $movement['supplierName'],
                    sprintf('Matrículas cargpadas: %d/%d | Matrículas descargpadas: %d/%d', $movement['assignedLicensePlateUnits']['load'], $movement['assignedLicensePlateUnits']['total'], $movement['assignedLicensePlateUnits']['unload'], $movement['assignedLicensePlateUnits']['total']),
                    $movement['manualCost'],
                    $movement['expectedLoadDate'],
                    $actualLoadDate,
                    $actualLoadTime,
                    $movement['expectedUnloadDate'],
                    $actualUnloadDate,
                    $actualUnloadTime,
                    $movement['originLocation'] ?? $movement['externalOriginLocation'] ?? sprintf('%s | %s', $movement['manualOriginLocation']['state']->getName(), $movement['manualOriginLocation']['country']->getName()),
                    $movement['originBranchName'],
                    $movement['destinationLocation'] ?? $movement['externalDestinationLocation'] ?? sprintf('%s | %s', $movement['manualDestinationLocation']['state']->getName(), $movement['manualDestinationLocation']['country']->getName()),
                    $movement['destinationBranchName'],
                    $movement['creationUser']['name'],
                    $movement['creationDate'] ? $movement['creationDate']->__toString("d/m/Y") : null,
                    $movement['creationDate'] ? $movement['creationDate']->__toString("H:i") : null,
                ];
            }
        }
        if ($movementTypeId === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_OPERATION'))) {
            $movementExcel[] = [
                'Nª de movimiento',
                'Estado del movimiento',
                'Unidades Negocio-Articulo',
                'Proveedor',
                'Unidades',
                'Importe',
                'Fecha prevista carga',
                'Fecha real carga',
                'Hora real carga',
                'Fecha prevista descarga',
                'Fecha real descarga',
                'Hora real descarga',
                'Localizacion origen',
                'Delegación origen',
                'Localizacion destino',
                'Delegación destino',
                'Usuario creacion',
                'Fecha creación',
                'Hora creación',
            ];
            foreach ($movementList as $key => $movement) {
                [$actualLoadDate, $actualLoadTime, $actualUnloadDate, $actualUnloadTime] = null;
                // Fecha/hora real carga
                if ($movement['actualLoadDate']) {
                    $actualLoadDate = $movement['actualLoadDate']->__toString("d/m/Y");
                    $actualLoadTime = $movement['actualLoadDate']->__toString("H:i");
                } else if ($movement['lastActualLoadDate']) {
                    $actualLoadDate = $movement['lastActualLoadDate']->__toString("d/m/Y");
                    $actualLoadTime = $movement['lastActualLoadDate']->__toString("H:i");
                } else if ($movement['firstActualLoadDate']) {
                    $actualLoadDate = $movement['firstActualLoadDate']->__toString("d/m/Y");
                    $actualLoadTime = $movement['firstActualLoadDate']->__toString("H:i");
                }
                // Fecha/hora real descarga
                if ($movement['actualUnloadDate']) {
                    $actualUnloadDate = $movement['actualUnloadDate']->__toString("d/m/Y");
                    $actualUnloadTime = $movement['actualUnloadDate']->__toString("H:i");
                } else if ($movement['lastActualUnloadDate']) {
                    $actualUnloadDate = $movement['lastActualUnloadDate']->__toString("d/m/Y");
                    $actualUnloadTime = $movement['lastActualUnloadDate']->__toString("H:i");
                } else if ($movement['firstActualUnloadDate']) {
                    $actualUnloadDate = $movement['firstActualUnloadDate']->__toString("d/m/Y");
                    $actualUnloadTime = $movement['firstActualUnloadDate']->__toString("H:i");
                }

                $movementExcel[] = [
                    $movement['id'],
                    $movement['movementStatus']['name'],
                    sprintf("%s/%s", $movement['businessUnitName'], $movement['businessUnitArticleName']),
                    $movement['supplierName'],
                    $movement['vehicleUnits'],
                    $movement['manualCost'],
                    $movement['expectedLoadDate'],
                    $actualLoadDate,
                    $actualLoadTime,
                    $movement['expectedUnloadDate'],
                    $actualUnloadDate,
                    $actualUnloadTime,
                    $movement['originLocation'] ?? $movement['externalOriginLocation'] ?? sprintf('%s | %s', $movement['manualOriginLocation']['state']->getName(), $movement['manualOriginLocation']['country']->getName()),
                    $movement['originBranchName'],
                    $movement['destinationLocation'] ?? $movement['externalDestinationLocation'] ?? sprintf('%s | %s', $movement['manualDestinationLocation']['state']->getName(), $movement['manualDestinationLocation']['country']->getName()),
                    $movement['destinationBranchName'],
                    $movement['creationUser']['name'],
                    $movement['creationDate'] ? $movement['creationDate']->__toString("d/m/Y") : null,
                    $movement['creationDate'] ? $movement['creationDate']->__toString("H:i") : null,
                ];
            }
        }


        return $movementExcel;
    }

    private function createVehicleExcelArrayFormatter(array $movementList): array
    {
        $movementExcel[] = [
            'Nº de movimiento',
            'Nº de pedido',
            'Unidades Negocio-Articulo',
            'Proveedor',
            'Matricula',
            'Bastidor',
            'Marca',
            'Modelo',
            'Grupo',
            'Localización origen',
            'Delegación origen',
            'Localización destino',
            'Delegación destino',
            'Fecha prevista carga',
            'Fecha real carga',
            'Hora real carga',
            'Fecha prevista descarga',
            'Fecha real descarga',
            'Hora real descarga',
            'Estado del movimiento',
            'Usuario creacion',
            'Fecha creacion',
            'Hora creacion',
        ];

        foreach ($movementList as $movement) {
            [$actualLoadDate, $actualLoadTime, $actualUnloadDate, $actualUnloadTime] = null;
            // Fecha/hora real carga
            if ($movement['actualLoadDate']) {
                $actualLoadDate = $movement['actualLoadDate']->__toString("d/m/Y");
                $actualLoadTime = $movement['actualLoadDate']->__toString("H:i");
            } else if ($movement['lastActualLoadDate']) {
                $actualLoadDate = $movement['lastActualLoadDate']->__toString("d/m/Y");
                $actualLoadTime = $movement['lastActualLoadDate']->__toString("H:i");
            } else if ($movement['firstActualLoadDate']) {
                $actualLoadDate = $movement['firstActualLoadDate']->__toString("d/m/Y");
                $actualLoadTime = $movement['firstActualLoadDate']->__toString("H:i");
            }
            // Fecha/hora real descarga
            if ($movement['actualUnloadDate']) {
                $actualUnloadDate = $movement['actualUnloadDate']->__toString("d/m/Y");
                $actualUnloadTime = $movement['actualUnloadDate']->__toString("H:i");
            } else if ($movement['lastActualUnloadDate']) {
                $actualUnloadDate = $movement['lastActualUnloadDate']->__toString("d/m/Y");
                $actualUnloadTime = $movement['lastActualUnloadDate']->__toString("H:i");
            } else if ($movement['firstActualUnloadDate']) {
                $actualUnloadDate = $movement['firstActualUnloadDate']->__toString("d/m/Y");
                $actualUnloadTime = $movement['firstActualUnloadDate']->__toString("H:i");
            }

            foreach ($movement['vehicle'] as $key => $vehicle) {
                $movementExcel[] = [
                    $movement['id'],
                    $movement['orderNumber'],
                    sprintf("%s/%s", $movement['businessUnitName'], $movement['businessUnitArticleName']),
                    $movement['supplierName'],
                    $vehicle['licensePlate'],
                    $vehicle['vin'],
                    $vehicle['brandName'],
                    $vehicle['modelName'],
                    $vehicle['carGroupName'],
                    $movement['originBranchName'],
                    $movement['originLocation'] ?? $movement['externalOriginLocation'] ?? `{$movement['manualOriginLocation']['counrty']} / {$movement['manualOriginLocation']['state']}`,
                    $movement['destinationBranchName'],
                    $movement['destinationLocation'] ?? $movement['externalDestinationLocation'] ?? `{$movement['manualDestinationLocation']['counrty']} / {$movement['manualDestinationLocation']['state']}`,
                    $movement['expectedLoadDate'],
                    $actualLoadDate,
                    $actualLoadTime,
                    $movement['expectedUnloadDate'],
                    $actualUnloadDate,
                    $actualUnloadTime,
                    $movement['movementStatus']['name'],
                    $movement['creationUser']['name'],
                    $movement['creationDate'] ? $movement['creationDate']->__toString("d/m/Y") : null,
                    $movement['creationDate'] ? $movement['creationDate']->__toString("H:i") : null,
                ];
            }
        }

        if (count($movementExcel) == 1) {
            throw new MovementException('Vehicles not found');
        }

        return $movementExcel;
    }
}
