<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CancelMovement;

use Distribution\Movement\Domain\MovementStatus;
use Distribution\Movement\Domain\MovementRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

class CancelMovementCommandHandler
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
     * @param CancelMovementCommand $command
     * @return CancelMovementResponse
     */
    public function handle(CancelMovementCommand $command): CancelMovementResponse
    {
        $movement = $this->movementRepository->getById($command->getMovementId());

        $movement->setStatus(new MovementStatus(intval(ConstantsJsonFile::getValue("TRANSPORTSTATUS_CANCELLED"))));
        $movement->setCancellationNotes($command->getCancelationNotes());

        $response = $this->movementRepository->update($movement);

        return new CancelMovementResponse(
            $response->getOperationResponse()->wasSuccess(),
            $response->getOperationResponse()->getCode(),
            $response->getOperationResponse()->getMessage()
        );
    }
}
