<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ShowMovement;

use Distribution\Location\Domain\Location;
use Distribution\Movement\Domain\Supplier;
use Distribution\Movement\Domain\VehicleLine;
use Distribution\Movement\Domain\MovementException;
use Distribution\Location\Domain\LocationRepository;
use Distribution\Movement\Domain\MovementRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Distribution\Movement\Domain\Location as MovementLocation;

class ShowMovementQueryHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;

    /**
     * ShowMovementQueryHandler constructor
     * 
     * @param MovementRepository $movementRepository
     * @param LocationRepository $locationRepository
     */
    public function __construct(
        MovementRepository $movementRepository,
        LocationRepository $locationRepository
    ) {
        $this->movementRepository = $movementRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param ShowMovementQuery $query
     * @return ShowMovementResponse
     */
    public function handle(ShowMovementQuery $query): ShowMovementResponse
    {
        $movement = $this->movementRepository->getById($query->getId());
        if (empty($movement)) {
            throw new MovementException('Error getting Movement');
        }

        [
            $locationType,
            $driverData,
            $expectedLoadDate,
            $actualLoadDate,
            $expectedUnloadDate,
            $actualUnloadDate,
            $filterVehicleTypeName,
            $filterBrandName,
            $filterModelName,
            $filterCarGroupName,
            $kilometersFrom,
            $kilometersTo,
            $rentingEndDateFrom,
            $rentingEndDateTo,
            $checkInDateFrom,
            $filterSaleMethodName,
            $filterVehicleStatusName,
            $filterConnectedVehicle,
            $assignedLicensePlateUnits,
            $cancellationData,
            $closingData,
        ] = null;

        /**
         * Only for DRIVER
         */
        if ($movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER"))) {
            $locationType = $movement->getDestinationLocation() ? $movement->getDestinationLocation()->getLocationType()->getName() : null;

            $driverData = [
                'name' => $movement->getDriver() ? $movement->getDriver()->getName() : null,
                'lastName' => $movement->getDriver() ? $movement->getDriver()->getLastName() : null,
                'idNumber' => $movement->getDriver() ? $movement->getDriver()->getIdNumber() : null,
                'driverLicense' => $movement->getDriver() ? $movement->getDriver()->getDriverLicense() : null,
                'driverLicenseIssueDate' => $movement->getDriver() ? $movement->getDriver()->getDriverLicenseIsueDate()->__toString() : null,
                'address' => $movement->getDriver() ? $movement->getDriver()->getAddress() : null,
                'state' => $movement->getDriver() ? $movement->getDriver()->getState() : null,
                'city' => $movement->getDriver() ? $movement->getDriver()->getCity() : null,
                'postalCode' => $movement->getDriver() ? $movement->getDriver()->getPostalCode() : null,
                'country' => $movement->getDriver() ? $movement->getDriver()->getCountry() : null,
            ];

            $expectedLoadDate = $movement->getExpectedLoadDate() ? $movement->getExpectedLoadDate()->__toString() : null;
            $expectedUnloadDate = $movement->getExpectedUnloadDate() ? $movement->getExpectedUnloadDate()->__toString() : null;

            // FIXME esta lógica es un parche temporal para declarar si una localización es externa o no. Refactorizar cuando se cambie el response de WS
            if ($movement->getDestinationLocation()) {
                /**
                 * @var Location $location
                 */
                $location = $this->locationRepository->getById($movement->getDestinationLocation()->getId());

                if ($location->getProvider()) {
                    $movement->setDestinationExternalSupplier(new Supplier(
                        $location->getProvider()->getId(),
                        $location->getProvider()->getName()
                    ));
                    $movement->setDestinationExternalLocation(new MovementLocation(
                        $movement->getDestinationLocation()->getId(),
                        $movement->getDestinationLocation()->getName()
                    ));
                    $movement->setDestinationLocation(null);
                }
            }

            if (!empty($movement->getVehicleLineCollection()) && $movement->getVehicleLineCollection()->count() > 0) {
                // Obtenemos un vehículo en movimiento por conductor

                /**
                 * @var VehicleLine $vehicleLine
                 */
                $vehicleLine = $movement->getVehicleLineCollection()[0];

                $vehicle = [
                    'id' =>  $vehicleLine->getVehicle()->getId(),
                    'licensePlate' => $vehicleLine->getVehicle()->getLicensePlate(),
                    'vin' =>  $vehicleLine->getVehicle()->getVin(),
                    'carClass' => ($vehicleLine->getVehicle()->getCarClass()) ?  $vehicleLine->getVehicle()->getCarClass()->getName() : null,
                    'vehicleGroup' => ($vehicleLine->getVehicle()->getCarGroup()) ? $vehicleLine->getVehicle()->getCarGroup()->getName() : null,
                    'acriss' => ($vehicleLine->getVehicle()->getAcriss()) ? $vehicleLine->getVehicle()->getAcriss()->getName() : null,
                    'brand' => ($vehicleLine->getVehicle()->getBrand()) ? $vehicleLine->getVehicle()->getBrand()->getName() : null,
                    'model' => ($vehicleLine->getVehicle()->getModel()) ? $vehicleLine->getVehicle()->getModel()->getName() : null,
                    'trim' => $vehicleLine->getVehicle()->getTrimName(),
                    'status' => ($vehicleLine->getVehicle()->getStatus()) ? $vehicleLine->getVehicle()->getStatus()->getName() : null,
                    'rentingEndDate' => $vehicleLine->getVehicle()->getRentingEndDate() ? $vehicleLine->getVehicle()->getRentingEndDate()->__toString() : null,
                    'region' => ($vehicleLine->getVehicle()->getRegion()) ? $vehicleLine->getVehicle()->getRegion()->getName() : null,
                    'area' => ($vehicleLine->getVehicle()->getArea()) ? $vehicleLine->getVehicle()->getArea()->getName() : null,
                    'branch' => ($vehicleLine->getVehicle()->getBranch()) ? $vehicleLine->getVehicle()->getBranch()->getName() : null,
                    'location' => ($vehicleLine->getVehicle()->getLocation()) ? $vehicleLine->getVehicle()->getLocation()->getName() : null,
                    'actualKms' => $vehicleLine->getVehicle()->getActualKms() ?: null,
                ];

                $actualLoadDate = $vehicleLine->getActualLoadDate();
                $actualUnloadDate = $vehicleLine->getActualUnloadDate();

                // Datos de cierre
                if ($vehicleLine->getVehicleRecordsUnload() && $vehicleLine->getActualUnloadDate() !== null) {
                    $actualUnloadDate = $vehicleLine->getActualUnloadDate()->__toString();

                    $closingData = [
                        'closingUser' => $movement->getEditionUser()->getName(),
                        'closingDate' => $movement->getEditionDate()->__toString(),
                        'actualKms' => $vehicleLine->getVehicleRecordsUnload() ? $vehicleLine->getVehicleRecordsUnload()->getKilometersActual() : null,
                        'tankActualOctaves' => $vehicleLine->getVehicleRecordsUnload() ? $vehicleLine->getVehicleRecordsUnload()->getTankActualOctaves() : null,
                        'batteryActual' => $vehicleLine->getVehicleRecordsUnload() ? $vehicleLine->getVehicleRecordsUnload()->getBatteryActual() : null
                    ];
                }

                // Datos cancelación
                if ($vehicleLine->getVehicleDelete() !== null) {
                    $cancellationData = [
                        'cancellationUser' => $vehicleLine->getVehicleDelete()->getCreationUser()->getName(),
                        'cancellationDate' => $vehicleLine->getVehicleDelete()->getCreationDate()->__toString(),
                    ];
                }
            }
        }

        /**
         * CARRIER, OPERATION
         */
        if (in_array($movement->getMovementType()->getId(), [ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER"), ConstantsJsonFile::getValue("TRANSPORTTYPE_OPERATION")])) {
            /**
             * Filters
             */
            if (!empty($movement->getVehicleFilterCollection())) {
                foreach ($movement->getVehicleFilterCollection() as  $vehicleFilter) {
                    foreach ($vehicleFilter->getVehicleTypeCollection() as $key => $vehicleType) {
                        $filterVehicleTypeName .= ($key === 0) ? $vehicleType->getName() : ', ' . $vehicleType->getName();
                    }

                    foreach ($vehicleFilter->getBrandCollection() as $key => $brand) {
                        $filterBrandName .= ($key === 0) ? $brand->getName() : ', ' . $brand->getName();
                    }

                    foreach ($vehicleFilter->getModelCollection() as $key => $model) {
                        $filterModelName .= ($key === 0) ? $model->getName() : ', ' . $model->getName();
                    }

                    foreach ($vehicleFilter->getCarGroupCollection() as $key => $vehicleGroup) {
                        $filterCarGroupName .= ($key === 0) ? $vehicleGroup->getName() : ', ' . $vehicleGroup->getName();
                    }

                    foreach ($vehicleFilter->getSaleMethodCollection() as $key => $saleMethod) {
                        $filterSaleMethodName .= ($key === 0) ? $saleMethod->getName() : ', ' . $saleMethod->getName();
                    }

                    foreach ($vehicleFilter->getVehicleStatusCollection() as $key => $vehicleStatus) {
                        $filterVehicleStatusName .= ($key === 0) ? $vehicleStatus->getName() : ', ' . $vehicleStatus->getName();
                    }

                    $kilometersFrom = $vehicleFilter->getKilometersFrom();
                    $kilometersTo = $vehicleFilter->getKilometersTo();
                    $rentingEndDateFrom = $vehicleFilter->getRentingEndDateFrom();
                    $rentingEndDateTo = $vehicleFilter->getRentingEndDateTo();
                    $checkInDateFrom = $vehicleFilter->getCheckInDateFrom();
                    $filterConnectedVehicle = $vehicleFilter->isConnectedVehicle();
                }
            }

            $locationType = $movement->getOriginLocation() ? $movement->getOriginLocation()->getLocationType()->getName() : ($movement->getDestinationLocation() ? $movement->getDestinationLocation()->getLocationType()->getName() : null);

            $expectedLoadDate = $movement->getExpectedLoadDate() ? $movement->getExpectedLoadDate()->__toString() : null;
            $expectedUnloadDate = $movement->getExpectedUnloadDate() ? $movement->getExpectedUnloadDate()->__toString() : null;
            // $actualLoadDate = $movement->getActualLoadDate() ? $movement->getActualLoadDate()->__toString() : null;
            // $actualUnloadDate = $movement->getActualUnloadDate() ? $movement->getActualUnloadDate()->__toString() : null;

            if ($movement->getVehicleLineCollection() && $movement->getVehicleLineCollection()->count() > 0) {
                $activeLines = array_filter($movement->getVehicleLineCollection()->toArray(), function ($line) {
                    return $line->getVehicleDelete() == null;
                });

                if (count($activeLines) > 0) {
                    $loadDates = array_filter(array_map(function ($line) {
                        return $line->getActualLoadDate();
                    }, $activeLines), function ($date) {
                        return $date !== null;
                    });
                    $actualLoadDate = array_filter($loadDates, function ($date) use ($loadDates) {
                        return $date->getValue() === min(array_map(function ($date) {
                            return $date->getValue();
                        }, $loadDates));
                    })[0] ?? null;

                    $unloadDates = array_filter(array_map(function ($line) {
                        return $line->getActualUnloadDate();
                    }, $activeLines), function ($date) {
                        return $date !== null;
                    });
                    $actualUnloadDate = array_filter($unloadDates, function ($date) use ($unloadDates) {
                        return $date->getValue() === min(array_map(function ($date) {
                            return $date->getValue();
                        }, $unloadDates));
                    })[0] ?? null;
                }
            }

            $assignedLicensePlateUnits = [
                'total' => $movement->getAssignedLicensePlateUnits()->getTotal(),
                'load' => $movement->getAssignedLicensePlateUnits()->getLoad(),
                'unload' => $movement->getAssignedLicensePlateUnits()->getUnload(),
            ];

            if ($movement->getMovementStatus()->getId() === intval(ConstantsJsonFile::getValue("TRANSPORTSTATUS_FINISHED"))) {
                $closingData = [
                    'closingUser' => $movement->getEditionUser()->getName(),
                    'closingDate' => $movement->getEditionDate()->__toString(),
                    'actualKms' => null,
                    'tankActualOctaves' => null,
                    'batteryActual' => null
                ];
            }

            if ($movement->getMovementStatus()->getId() === intval(ConstantsJsonFile::getValue("TRANSPORTSTATUS_CANCELLED"))) {
                $cancellationData = [
                    'cancellationUser' => $movement->getEditionUser()->getName(),
                    'cancellationDate' => $movement->getEditionDate()->__toString(),
                ];
            }
        }

        $movementArray = [
            'id' => $movement->getId(),
            'orderNumber' => $movement->getOrderNumber(),
            'movementTypeName' => $movement->getMovementType() ? $movement->getMovementType()->getName() : null,
            'status' => ($movement->getMovementStatus()) ?
                [
                    'id' => $movement->getMovementStatus()->getId(),
                    'name' => $movement->getMovementStatus()->getName(),
                ] : null,
            'category' => $movement->getMovementCategory() ?
                [
                    'id' => $movement->getMovementCategory()->getId(),
                    'name' => $movement->getMovementCategory()->getName(),
                ] : null,
            'externalTransport' => $movement->isExtTransport(),
            'locationType' => $locationType,

            'originBranch' => $movement->getOriginBranch() ? $movement->getOriginBranch()->getName() : null,
            'originLocation' => $movement->getOriginLocation() ? $movement->getOriginLocation()->getName() : null,
            'externalOriginLocation' => $movement->getOriginExternalLocation() ? $movement->getOriginExternalLocation()->getName() : null,
            'manualOriginLocation' => (!empty($movement->getManualOriginLocation())) ?
                [
                    'state' => $movement->getManualOriginLocation()->getState()->getName(),
                    'country' => $movement->getManualOriginLocation()->getCountry()->getName(),
                    'notes' => $movement->getManualOriginLocation()->getNotes(),
                ] : null,
            'destinationBranch' => $movement->getDestinationBranch() ? $movement->getDestinationBranch()->getName() : null,
            'destinationLocation' => $movement->getDestinationLocation() ? $movement->getDestinationLocation()->getName() : null,
            'externalDestinationLocation' => $movement->getDestinationExternalLocation() ? $movement->getDestinationExternalLocation()->getName() : null,
            'manualDestinationLocation' => (!empty($movement->getManualDestinationLocation())) ?
                [
                    'state' => $movement->getManualDestinationLocation()->getState()->getName(),
                    'country' => $movement->getManualDestinationLocation()->getCountry()->getName(),
                    'notes' => $movement->getManualDestinationLocation()->getNotes(),
                ] : null,

            'expectedLoadDate' =>  $expectedLoadDate,
            'actualLoadDate' => $actualLoadDate,
            'expectedUnloadDate' => $expectedUnloadDate,
            'actualUnloadDate' => $actualUnloadDate,
            'department' => $movement->getDepartment() ? $movement->getDepartment()->getName() : null,
            'provider' => $movement->getSupplier() ? $movement->getSupplier()->getName() : null,
            'providerType' => $movement->getSupplier() && $movement->getSupplier()->getSupplierType() ? $movement->getSupplier()->getSupplierType()->getName() : null,
            'businessUnit' => $movement->getBusinessUnit() ? $movement->getBusinessUnit()->getName() : null,
            'businessUnitArticle' => $movement->getBusinessUnitArticle() ? $movement->getBusinessUnitArticle()->getName() : null,
            'transportMethod' => $movement->getTransportMethod() ?
                [
                    'id' => $movement->getTransportMethod()->getId(),
                    'name' => $movement->getTransportMethod()->getName(),
                ] : null,
            'vehicleUnits' => $movement->getVehicleUnits(),
            'manualCost' => $movement->getManualCost(),
            'automaticCost' => $movement->getAutomaticCost(),
            'notes' => $movement->getNotes(),

            'driver' => $driverData,
            'vehicle' => $movement->getMovementType()->getId() == ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER") ? $vehicle : [],
            'filters' => [
                'vehicleType' => $filterVehicleTypeName,
                'brand' => $filterBrandName,
                'model' => $filterModelName,
                'carGroup' => $filterCarGroupName,
                'kilometersFrom' => $kilometersFrom,
                'kilometersTo' => $kilometersTo,
                'rentingEndDateFrom' => $rentingEndDateFrom,
                'rentingEndDateTo' => $rentingEndDateTo,
                'checkInDateFrom' => $checkInDateFrom,
                'saleMethod' => $filterSaleMethodName,
                'vehicleStatus' => $filterVehicleStatusName,
                'connectedVehicle' => $filterConnectedVehicle,
            ],
            'assignedLicensePlateUnits' => $assignedLicensePlateUnits,

            'creationUser' => $movement->getCreationUser()->getName(),
            'creationDate' => $movement->getCreationDate()->__toString(),
            'editionUser' => $movement->getEditionUser() ? $movement->getEditionUser()->getName() : null,
            'editionDate' => $movement->getEditionDate() ? $movement->getEditionDate()->__toString() : null,

            // Datos de cierre
            'actualKms' => $closingData ? $closingData['actualKms'] : null,
            'tankActualOctaves' => $closingData ? $closingData['tankActualOctaves'] : null,
            'batteryActual' => $closingData ? $closingData['batteryActual'] : null,
            'closingUser' => $closingData ? $closingData['closingUser'] : null,
            'closingDate' =>  $closingData ? $closingData['closingDate'] : null,
            'closingNotes' =>  $closingData ? $movement->getClosingNotes() : null,

            // Datos de cancelación
            'cancellationUser' => $cancellationData ? $cancellationData['cancellationUser'] : null,
            'cancellationDate' => $cancellationData ? $cancellationData['cancellationDate'] : null,
            'cancellationNotes' => $movement->getCancellationNotes(),
        ];

        return new ShowMovementResponse(
            $movement->getMovementType()->getId(),
            $movementArray
        );
    }
}
