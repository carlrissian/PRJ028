<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\GetByIdPdfMovement;

use Distribution\Movement\Domain\MovementException;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\Movement\Domain\VehicleLine;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

class GetByIdPdfMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * GetByIdPdfMovementCommandHandler constructor.
     * 
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @throws MovementException
     */
    public function  handle(GetByIdPdfMovementCommand $command)
    {
        $movement = $this->movementRepository->getById($command->getMovementId());

        if (empty($movement)) {
            throw new MovementException('Error getting movement');
        }


        [
            $vehicle,
            $driverName,
            $driverLastName,
            $driverDni,
            $manualOriginLocation,
            $manualDestinationLocation,
            $originBranchName,
            $destinationBranchName,
            $actualLoadDate,
            $actualUnloadDate,
            $firstActualLoadDate,
            $firstActualUnloadDate,
            $lastActualLoadDate,
            $lastActualUnloadDate,
            $closingUser,
            $closingDate,
            $cancellationUser,
            $cancellationDate,
        ] = null;
        $movementTypeId = $movement->getMovementType()->getId();


        /**
         * DRIVER
         */
        if ($movementTypeId === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_DRIVER'))) {
            /**
             * @var VehicleLine $vehicleLine
             */
            $vehicleLine = $movement->getVehicleLineCollection()->toArray()[0];

            $vehicle = [
                // 'id' => $vehicleLine->getVehicle()->getId(),
                'vehicleStatus' => $vehicleLine->getVehicle()->getStatus() ? $vehicleLine->getVehicle()->getStatus()->getName() : null,
                'licensePlate' => $vehicleLine->getVehicle()->getLicensePlate(),
                'brandName' => $vehicleLine->getVehicle()->getBrand()->getName(),
                'modelName' => $vehicleLine->getVehicle()->getModel()->getName(),
                // 'kilometers' => $vehicleLine->getVehicle()->getActualKms(),
                // 'tankCapacity' => $vehicleLine->getVehicle()->getTankCapacity(),
                // 'batteryCapacity' => $vehicleLine->getVehicle()->getBatteryCapacity(),
                'kilometersActual' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getKilometersActual() : null,
                'batteryActual' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getBatteryActual() : null,
            ];

            $actualLoadDate = $vehicleLine->getActualLoadDate();
            $actualUnloadDate = $vehicleLine->getActualUnloadDate();


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

            // Datos del conductor
            $driverName = $movement->getDriver() ? $movement->getDriver()->getName() : null;
            $driverLastName = $movement->getDriver() ? $movement->getDriver()->getLastName() : null;
            $driverDni = $movement->getDriver() ? $movement->getDriver()->getIdNumber() : null;

            // Datos de cancelación
            if ($vehicleLine->getVehicleDelete() !== null) {
                $cancelationUser = $vehicleLine->getVehicleDelete()->getCreationUser()->getName();
                $cancelationDate = $vehicleLine->getVehicleDelete()->getCreationDate()->__toString();
            }
        }


        /**
         * CARRIER, OPERATION
         */
        if (in_array($movementTypeId, [(int) ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'),  (int) ConstantsJsonFile::getValue('TRANSPORTTYPE_OPERATION')]) && !empty($movement->getVehicleLineCollection())) {
            $vehicle = [];

            foreach ($movement->getVehicleLineCollection() as $vehicleLine) {
                // TODO mostrar líneas canceladas (?)
                if ($vehicleLine->getVehicleDelete() === null) {
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
                        'saleMethod' => $vehicleLine->getVehicle()->getSaleMethod() ? $vehicleLine->getVehicle()->getSaleMethod()->getName() : null,
                        'dateBlockage' => $vehicleLine->getVehicle()->getInitBlockDate(),
                        'dateBlockageEnd' => $vehicleLine->getVehicle()->getEndBlockDate(),
                        'actualLoadDate' => $vehicleLine->getActualLoadDate(),
                        'actualUnloadDate' => $vehicleLine->getActualUnloadDate(),
                        'vehicleMaintenanceEndDate' => $vehicleLine->getVehicleMaintenanceEndDate(),
                    ];
                }
            }

            // Recolección de fecha de carga/descarga más reciente y más antigua
            $activeLines = array_filter($movement->getVehicleLineCollection()->toArray(), function ($line) {
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

                // INFO de momento usaremos las últimas fechas de carga y descarga
                $actualLoadDate = $lastActualLoadDate;
                $actualUnloadDate = $lastActualUnloadDate;

                if ($movement->getMovementStatus()->getId() === intval(ConstantsJsonFile::getValue("TRANSPORTSTATUS_CANCELLED"))) {
                    $cancellationUser = $movement->getEditionUser() ? $movement->getEditionUser()->getName() : null;
                    $cancellationDate = $movement->getEditionDate() ? $movement->getEditionDate()->__toString() : null;
                }
            }
        }

        if ($movement->getMovementStatus()->getId() === intval(ConstantsJsonFile::getValue("TRANSPORTSTATUS_FINISHED"))) {
            $closingUser = $movement->getEditionUser() ? $movement->getEditionUser()->getName() : null;
            $closingDate = $movement->getEditionDate() ? $movement->getEditionDate()->__toString() : null;
        }

        // Origin branch
        if (!empty($movement->getOriginLocation()) && !empty($movement->getOriginLocation()->getBranch())) {
            $originBranchName = $movement->getOriginLocation()->getBranch()->getName();
        } else if (!empty($movement->getOriginExternalLocation()) && !empty($movement->getOriginExternalLocation()->getBranch())) {
            $originBranchName = $movement->getOriginExternalLocation()->getBranch()->getName();
        } else if (!empty($movement->getOriginBranch())) {
            $originBranchName = $movement->getOriginBranch()->getName();
        }
        // Destination branch
        if (!empty($movement->getDestinationLocation()) && !empty($movement->getDestinationLocation()->getBranch())) {
            $destinationBranchName = $movement->getDestinationLocation()->getBranch()->getName();
        } else if (!empty($movement->getDestinationExternalLocation()) && !empty($movement->getDestinationExternalLocation()->getBranch())) {
            $destinationBranchName = $movement->getDestinationExternalLocation()->getBranch()->getName();
        } else if (!empty($movement->getDestinationBranch())) {
            $destinationBranchName = $movement->getDestinationBranch()->getName();
        }


        $movement = [
            'id' => $movement->getId(),
            'orderNumber' => $movement->getOrderNumber(),
            'movementTypeName' => $movement->getMovementType() ? $movement->getMovementType()->getName() : null,
            'movementCategoryName' => $movement->getMovementCategory() ? $movement->getMovementCategory()->getName() : null,
            'movementStatus' => $movement->getMovementStatus() ? [
                'id' => $movement->getMovementStatus()->getId(),
                'name' => $movement->getMovementStatus()->getName(),
            ] : null,

            'originLocation' => $movement->getOriginLocation() ? $movement->getOriginLocation()->getName() : null,
            'externalOriginLocation' => $movement->getOriginExternalLocation() ? $movement->getOriginExternalLocation()->getName() : null,
            'manualOriginLocation' => $manualOriginLocation,
            'originBranchName' => $originBranchName,
            'destinationLocation' => $movement->getDestinationLocation() ? $movement->getDestinationLocation()->getName() : null,
            'externalDestinationLocation' => $movement->getDestinationExternalLocation() ? $movement->getDestinationExternalLocation()->getName() : null,
            'manualDestinationLocation' => $manualDestinationLocation,
            'destinationBranchName' => $destinationBranchName,

            'expectedLoadDate' =>  $movement->getExpectedLoadDate() ?  $movement->getExpectedLoadDate()->__toString() : null,
            'actualLoadDate' => $actualLoadDate ? $actualLoadDate->__toString('d/m/Y') : null,
            'expectedUnloadDate' => $movement->getExpectedUnloadDate() ? $movement->getExpectedUnloadDate()->__toString() : null,
            'actualUnloadDate' => $actualUnloadDate ? $actualUnloadDate->__toString('d/m/Y') : null,

            'supplierName' => $movement->getSupplier() ? $movement->getSupplier()->getName() : null,
            'businessUnitName' => $movement->getBusinessUnit() ? $movement->getBusinessUnit()->getName() : null,
            'businessUnitArticleName' => $movement->getBusinessUnitArticle() ? $movement->getBusinessUnitArticle()->getName() : null,
            'vehicleUnits' => $movement->getVehicleUnits(),
            'manualCost' => $movement->getManualCost(),
            'automaticCost' => $movement->getAutomaticCost(),
            'notes' => $movement->getNotes(),

            'driverTypeName' => $movement->isExtTransport() ?  'Provider' : 'Employee',
            'driverName' => $driverName,
            'driverLastName' => $driverLastName,
            'driverDni' => $driverDni,
            'vehicle' => $vehicle,

            'creationUser' => $movement->getCreationUser() ? $movement->getCreationUser()->getName() : null,
            'creationDate' => $movement->getCreationDate() ?  $movement->getCreationDate()->__toString() : null,

            'closingUser' => $closingUser,
            'closingDate' => $closingDate,
            'closingNotes' => $movement->getClosingNotes(),

            'cancellationUser' => $cancellationUser,
            'cancellationDate' => $cancellationDate,
            'cancelationNotes' => $movement->getCancellationNotes(),
        ];

        return new GetByIdPdfMovementResponse($movementTypeId, $movement);
    }
}
