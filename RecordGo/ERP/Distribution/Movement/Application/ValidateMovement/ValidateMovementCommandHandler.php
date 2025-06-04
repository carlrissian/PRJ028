<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ValidateMovement;

use DateTime;
use Distribution\Movement\Domain\VehicleLine;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Movement\Domain\MovementRepository;

class ValidateMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param ValidateMovementCommand $command
     * @return ValidateMovementResponse
     */
    public function handle(ValidateMovementCommand $command): ValidateMovementResponse
    {
        $movement = $this->movementRepository->getById($command->getMovementId());

        if ($movement->getVehicleLineCollection() && $movement->getVehicleLineCollection()->count() > 0) {



            if ($command->getAction() == 'load') {
                $movement->setVehicleUnits($movement->getVehicleLineCollection()->count());

                $loadDates = array_map(function ($line) {
                    return $line->getActualLoadDate();
                }, $movement->getVehicleLineCollection()->toArray());
                if (!array_filter($loadDates, function ($date) {
                    return $date !== null;
                })) {
                    $movement->setActualLoadDate($command->getActualLoadDate() ? DateTimeValueObject::createFromString($command->getActualLoadDate()) : new DateTimeValueObject(new DateTime()));
                }
            }

            if ($command->getAction() == 'unload') {
                $unloadDates = array_map(function ($line) {
                    return $line->getActualUnloadDate();
                }, $movement->getVehicleLineCollection()->toArray());
                if (!array_filter($unloadDates, function ($date) {
                    return $date !== null;
                })) {
                    $movement->setActualUnloadDate($command->getActualUnloadDate() ? DateTimeValueObject::createFromString($command->getActualUnloadDate()) : new DateTimeValueObject(new DateTime()));
                }
            }

            foreach ($command->getVehicleLinesId() as $vehicleId) {
                /**
                 * @var VehicleLine $vehicleLine
                 */
                foreach ($movement->getVehicleLineCollection() as $vehicleLine) {
                    if ($vehicleLine->getVehicle()->getId() === intval($vehicleId)) {
                        switch ($command->getAction()) {
                            case 'load':
                                $vehicleLine->setActualLoadDate($command->getActualLoadDate() ? DateTimeValueObject::createFromString($command->getActualLoadDate()) : new DateTimeValueObject(new DateTime()));
                                break;
                            case 'unload':
                                $vehicleLine->setActualUnloadDate($command->getActualUnloadDate() ? DateTimeValueObject::createFromString($command->getActualUnloadDate()) : new DateTimeValueObject(new DateTime()));
                                break;
                        }
                    }

                    if ($vehicleLine->getVehicleDelete() !== null) {
                        $movement->getVehicleLineCollection()->removeByObject($vehicleLine);
                    }
                }
            }
        } else {
            return new ValidateMovementResponse(false, 'No vehicles assigned to the movement');
        }

        $movementOperationResponse = $this->movementRepository->update($movement);

        $success = $movementOperationResponse->getOperationResponse()->wasSuccess();
        $message = !$success ? $movementOperationResponse->getOperationResponse()->getMessage() : null;
        return new ValidateMovementResponse($success, $message);
    }
}
