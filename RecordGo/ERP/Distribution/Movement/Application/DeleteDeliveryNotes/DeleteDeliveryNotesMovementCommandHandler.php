<?php

namespace Distribution\Movement\Application\DeleteDeliveryNotes;

use Distribution\Movement\Domain\MovementRepository;

class DeleteDeliveryNotesMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * DeleteDeliveryNotesMovementCommandHandler constructor.
     * 
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param DeleteDeliveryNotesCommand $command
     * @return DeleteDeliveryNotesMovementResponse
     */
    public function handle(DeleteDeliveryNotesCommand $command): DeleteDeliveryNotesMovementResponse
    {
        $movement = $this->movementRepository->getById($command->getMovementId());

        $deliveryNoteCollection = $movement->getDeliveryNoteCollection();

        try {
            $deliveryNoteCollection->removeByProperty($command->getId(), 'id');
        } catch (\Exception $e) {
            throw new \Exception('Delivery note not found in collection', $e->getCode());
        }

        $movement->setDeliveryNoteCollection($deliveryNoteCollection);

        $deletedMovementId = $this->movementRepository->update($movement);

        return new DeleteDeliveryNotesMovementResponse(!!$deletedMovementId);
    }
}
