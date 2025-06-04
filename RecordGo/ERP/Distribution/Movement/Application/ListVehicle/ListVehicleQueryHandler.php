<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ListVehicle;

use Distribution\Movement\Domain\MovementRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

class ListVehicleQueryHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * ListVehicleQueryHandler constructor.
     * 
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param ListVehicleQuery $query
     * @return ListVehicleResponse
     */
    public function handle(ListVehicleQuery $query): ListVehicleResponse
    {
        [
            $vehicle,
            $assignedLicensePlateUnits,
            $expectedLoadDate,
            $expectedUnloadDate,
            $actualLoadDate,
            $actualUnloadDate,
            $firstActualLoadDate,
            $firstActualUnloadDate,
            $lastActualLoadDate,
            $lastActualUnloadDate,
        ] = null;

        $movement = $this->movementRepository->getById($query->getId());

        if (in_array($movement->getMovementType()->getId(), [ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER"), ConstantsJsonFile::getValue("TRANSPORTTYPE_OPERATION")])) {
            $expectedLoadDate = $movement->getExpectedLoadDate() ? $movement->getExpectedLoadDate()->__toString() : null;
            $expectedUnloadDate = $movement->getExpectedUnloadDate() ? $movement->getExpectedUnloadDate()->__toString() : null;

            foreach ($movement->getVehicleLineCollection() as $vehicleLine) {
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

            if ($movement->getVehicleLineCollection() && $movement->getVehicleLineCollection()->count() > 0) {
                $activeLines = array_filter($movement->getVehicleLineCollection()->toArray(), function ($line) {
                    return $line->getVehicleDelete() == null;
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

            $assignedLicensePlateUnits = [
                'total' => $movement->getAssignedLicensePlateUnits()->getTotal(),
                'load' => $movement->getAssignedLicensePlateUnits()->getLoad(),
                'unload' => $movement->getAssignedLicensePlateUnits()->getUnload(),
            ];
        }

        $movementArray = [
            'id' => $movement->getId(),
            'movementTypeId' => $movement->getMovementType()->getId(),
            'movementStatusId' => $movement->getMovementStatus()->getId(),

            'originLocation' => $movement->getOriginLocation() ? $movement->getOriginLocation()->getName() : null,
            'externalOriginLocation' => $movement->getOriginExternalLocation() ? $movement->getOriginExternalLocation()->getName() : null,
            'manualOriginLocation' => (!empty($movement->getManualOriginLocation())) ?
                [
                    'state' => $movement->getManualOriginLocation()->getState()->getName(),
                    'country' => $movement->getManualOriginLocation()->getCountry()->getName(),
                    'notes' => $movement->getManualOriginLocation()->getNotes(),
                ] : null,
            'destinationLocation' => $movement->getDestinationLocation() ? $movement->getDestinationLocation()->getName() : null,
            'externalDestinationLocation' => $movement->getDestinationExternalLocation() ? $movement->getDestinationExternalLocation()->getName() : null,
            'manualDestinationLocation' => (!empty($movement->getManualDestinationLocation())) ?
                [
                    'state' => $movement->getManualDestinationLocation()->getState()->getName(),
                    'country' => $movement->getManualDestinationLocation()->getCountry()->getName(),
                    'notes' => $movement->getManualDestinationLocation()->getNotes(),
                ] : null,

            'vehicle' => $vehicle,

            'expectedLoadDate' => $expectedLoadDate,
            'actualLoadDate' => $actualLoadDate,
            'firstActualLoadDate' => $firstActualLoadDate,
            'lastActualLoadDate' => $lastActualLoadDate,
            'expectedUnloadDate' => $expectedUnloadDate,
            'actualUnloadDate' => $actualUnloadDate,
            'firstActualUnloadDate' => $firstActualUnloadDate,
            'lastActualUnloadDate' => $lastActualUnloadDate,

            'transportMethodId' => $movement->getTransportMethod() ? $movement->getTransportMethod()->getId() : null,
            'businessUnitName' => $movement->getBusinessUnit() ? $movement->getBusinessUnit()->getName() : null,
            'supplierName' => ($movement->getSupplier()) ? $movement->getSupplier()->getName() : null,
            'automaticCost' => $movement->getAutomaticCost(),
            'assignedLicensePlateUnits' => $assignedLicensePlateUnits,
        ];


        return new ListVehicleResponse($movementArray);
    }
}
