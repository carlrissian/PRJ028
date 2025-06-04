<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CloseMovement;

use Exception;
use Distribution\Movement\Domain\Movement;
use Distribution\Movement\Domain\VehicleLine;
use Shared\Domain\ValueObject\FloatValueObject;
use Distribution\Movement\Domain\MovementStatus;
use Distribution\Movement\Domain\VehicleRecords;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Movement\Domain\MovementException;
use Distribution\Movement\Domain\MovementRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

class CloseMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * CloseMovementCommandHandler constructor.
     * 
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @throws MovementException
     * @throws Exception
     */
    public function handle(CloseMovementCommand $command): CloseMovementResponse
    {
        /**
         * @var Movement $movement
         */
        $movement = $this->movementRepository->getById($command->getId());

        if (empty($movement)) {
            throw new MovementException("Error getting movement with ID: {$command->getId()}");
        }
        if ($movement->getMovementType()->getId() !== intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER"))) {
            throw new MovementException('Movement type not allowed');
        }

        $movement->setManualCost($command->getManualCost() ? FloatValueObject::create($command->getManualCost()) : null);
        $movement->setClosingNotes($command->getClosingNotes());
        $movement->setStatus(new MovementStatus(intval(ConstantsJsonFile::getValue("TRANSPORTSTATUS_FINISHED"))));

        /**
         * @var VehicleLine $vehicleLine
         */
        $vehicleLine = $movement->getVehicleLineCollection()[0];
        $vehicleLine->setActualUnloadDate(DateTimeValueObject::createFromString($command->getActualUnloadDate()));
        $vehicleLine->setVehicleRecordsUnload(new VehicleRecords(
            $command->getActualKms(),
            $command->getBatteryActual() ? FloatValueObject::create($command->getBatteryActual()) : null,
            $command->getTankActualOctaves()
        ));

        $response = $this->movementRepository->update($movement);

        return new CloseMovementResponse(
            $response->getOperationResponse()->wasSuccess(),
            $response->getOperationResponse()->getCode(),
            $response->getOperationResponse()->getMessage()
        );
    }
}
