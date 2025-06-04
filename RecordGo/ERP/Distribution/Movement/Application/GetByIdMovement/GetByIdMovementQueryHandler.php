<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\GetByIdMovement;

use Distribution\Movement\Domain\MovementException;
use Distribution\Movement\Domain\MovementRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

class GetByIdMovementQueryHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * GetByIdPdfMovementCommandHandler constructor.
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @throws MovementException
     */
    public function  handle(int $movementId): GetByIdMovementResponse
    {
        [$vehicle, $originDelegation, $destinationDelegation] = null;

        $movement = $this->movementRepository->getById($movementId);

        if (empty($movement)) {
            throw new MovementException('Error getting Movement');
        }


        $originLocationName = $movement->getOriginLocation() ? $movement->getOriginLocation()->getName() : null;
        if (!empty($movement->getManualOriginLocation())) {
            $originDelegation = [
                'province' => $movement->getManualOriginLocation()->getState(),
                'country' => $movement->getManualOriginLocation()->getCountry(),
                'notes' => $movement->getManualOriginLocation()->getNotes(),
            ];
        }

        $destinationLocationName = $movement->getDestinationLocation() ? $movement->getDestinationLocation()->getName() : null;
        if (!empty($movement->getManualDestinationLocation())) {
            $destinationDelegation = [
                'province' => $movement->getManualDestinationLocation()->getState(),
                'country' => $movement->getManualDestinationLocation()->getCountry(),
                'notes' => $movement->getManualDestinationLocation()->getNotes(),
            ];
        }

        if ($movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_DRIVER'))  && !empty($movement->getVehicleLineCollection())) {
            /**
             * Obtenemos un conductor en movimiento por conductor
             */
            foreach ($movement->getVehicleLineCollection() as $key => $vehicleLine) {
                if ($key === 0) {
                    $vehicle = [
                        'brandName' => $vehicleLine->getVehicle()->getBrand() ? $vehicleLine->getVehicle()->getBrand()->getName() : null,
                        'modelName' => $vehicleLine->getVehicle()->getModel() ?  $vehicleLine->getVehicle()->getModel()->getName() : null,
                        'licensePlate' => $vehicleLine->getVehicle()->getLicensePlate(),
                        'kilometersActual' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getKilometersActual() : null,
                        'batteryActual' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getBatteryActual() : null,
                        'vehicleStatus' => $vehicleLine->getVehicle()->getStatus() ? $vehicleLine->getVehicle()->getStatus()->getName() : null,
                        'vehicleStatus' => $vehicleLine->getVehicle()->getStatus() ? $vehicleLine->getVehicle()->getStatus()->getName() : null,
                    ];
                }
            }
        }
        if (in_array($movement->getMovementType()->getId(), [ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'), ConstantsJsonFile::getValue('TRANSPORTTYPE_OPERATION')]) && !empty($movement->getVehicleLineCollection())) {
            $vehicle = [];
            foreach ($movement->getVehicleLineCollection() as $vehicleLine) {
                $vehicle[] = [
                    'vehicleId' => $vehicleLine->getVehicle()->getId(),
                    'brandName' => $vehicleLine->getVehicle()->getBrand() ? $vehicleLine->getVehicle()->getBrand()->getName() : null,
                    'vin' => $vehicleLine->getVehicle()->getVin(),
                    'modelName' => $vehicleLine->getVehicle()->getModel() ? $vehicleLine->getVehicle()->getModel()->getName() : null,
                    'carGroupName' => $vehicleLine->getVehicle()->getCarGroup() ? $vehicleLine->getVehicle()->getCarGroup()->getName() : null,
                    'licensePlate' => $vehicleLine->getVehicle()->getLicensePlate(),
                    'kilometersActual' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getKilometersActual() : null,
                    'batteryActual' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getBatteryActual() : null,
                    'vehicleStatus' => $vehicleLine->getVehicle()->getStatus() ? $vehicleLine->getVehicle()->getStatus()->getName() : null,
                    'saleBlockDate' => $vehicleLine->getVehicle()->getInitBlockDate() ? $vehicleLine->getVehicle()->getInitBlockDate()->__toString() : null,
                    'vehicleConnected' => $vehicleLine->getVehicle()->isConnected(),
                    'checkInDueDate' => $vehicleLine->getVehicle()->getCheckInDate() ? $vehicleLine->getVehicle()->getCheckInDate()->__toString() : null,
                    'actualLoadDate' => $vehicleLine->getActualLoadDate() ? $vehicleLine->getActualLoadDate()->__toString() : null,
                    'actualUnloadDate' => $vehicleLine->getActualUnloadDate() ? $vehicleLine->getActualUnloadDate()->__toString() : null,
                    'resaleCode' => $vehicleLine->getVehicle()->getSaleMethod() ? $vehicleLine->getVehicle()->getSaleMethod()->getName() : null,
                    'dateBlockage' => $vehicleLine->getVehicle()->getInitBlockDate() ? $vehicleLine->getVehicle()->getInitBlockDate()->__toString() : null,
                    'dateBlockageEnd' => $vehicleLine->getVehicle()->getEndBlockDate() ? $vehicleLine->getVehicle()->getEndBlockDate()->__toString() : null,
                    'vehicleMaintenanceEndDate' => $vehicleLine->getVehicleMaintenanceEndDate() ? $vehicleLine->getVehicleMaintenanceEndDate()->__toString() : null,
                ];
            }
        }

        $movementTypeId = $movement->getMovementType()->getId();
        $movement = [
            'orderMovement' => $movement->getId(),
            'orderNumber' => $movement->getOrderNumber(),
            'movementTypeName' => $movement->getMovementType() ?  $movement->getMovementType()->getName() : null,
            'movementStatus' => !empty($movement->getMovementStatus()) ? [
                'id' => $movement->getMovementStatus()->getId(),
                'name' => $movement->getMovementStatus()->getName(),
            ] : null,
            'movementCategoryName' => $movement->getMovementCategory() ?  $movement->getMovementCategory()->getName() : null,
            'driverTypeName' => $movement->isExtTransport() ?  'Provider' : 'Employee',
            'driverName' => $movement->getDriver() ? $movement->getDriver()->getName() : null,
            'driverLastName' => $movement->getDriver() ? $movement->getDriver()->getLastName() : null,
            'driverDni' => $movement->getDriver() ? $movement->getDriver()->getIdNumber() : null,

            'originLocationName' => $originLocationName,
            'originDelegation' => $originDelegation,
            'destinationLocationName' => $destinationLocationName,
            'destinationDelegation' => $destinationDelegation,

            'expectedLoadDate' =>  $movement->getExpectedLoadDate() ?  $movement->getExpectedLoadDate()->__toString() : null,
            'actualLoadDate' => $movement->getActualLoadDate() ? $movement->getActualLoadDate()->__toString() : null,
            'expectedUnloadDate' => $movement->getExpectedUnloadDate() ? $movement->getExpectedUnloadDate()->__toString() : null,
            'actualUnloadDate' => $movement->getActualUnloadDate() ? $movement->getActualUnloadDate()->__toString() : null,

            'supplierName' => $movement->getSupplier() ? $movement->getSupplier()->getName() : null,
            'businessUnitName' => $movement->getBusinessUnit() ? $movement->getBusinessUnit()->getName() : null,
            'businessUnitArticleName' => $movement->getBusinessUnitArticle() ? $movement->getBusinessUnitArticle()->getName() : null,
            'automaticCost' => $movement->getAutomaticCost(),
            'manualCost' => $movement->getManualCost(),
            'vehicleUnits' => $movement->getVehicleUnits(),
            'notes' =>  $movement->getNotes(),

            'vehicle' => $vehicle,

            'creationDate' => $movement->getCreationDate() ?  $movement->getCreationDate()->__toString() : null,
            'creationUser' => $movement->getCreationUser() ? $movement->getCreationUser()->getName() : null,
            'closingDate' => $movement->getClosingDate() ?  $movement->getClosingDate()->__toString() : null,
            'closingUser' => $movement->getClosingUser() ? $movement->getClosingUser()->getName() : null,
            'closingNotes' => $movement->getClosingNotes(),
            'cancelationDate' => $movement->getCancellationDate() ?  $movement->getCancellationDate()->__toString() : null,
            'cancelationUserName' => $movement->getCancellationUser() ? $movement->getCancellationUser()->getName() : null,
            'cancelationNotes' => $movement->getCancellationNotes(),
        ];

        return new GetByIdMovementResponse($movementTypeId, $movement);
    }
}
