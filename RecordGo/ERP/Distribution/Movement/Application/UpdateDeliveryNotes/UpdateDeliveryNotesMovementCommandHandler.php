<?php

namespace Distribution\Movement\Application\UpdateDeliveryNotes;

use DateTime;
use Distribution\Movement\Domain\DeliveryNote;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\Movement\Domain\DeliveryNoteCollection;

class UpdateDeliveryNotesMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * UpdateDeliveryNotesMovementCommandHandler constructor.
     * 
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param UpdateDeliveryNotesMovementCommand $command
     * @return UpdateDeliveryNotesMovementResponse
     */
    public function handle(UpdateDeliveryNotesMovementCommand $command): UpdateDeliveryNotesMovementResponse
    {
        $movement = $this->movementRepository->getById($command->getMovementId());

        $deliveryNoteCollection = $movement->getDeliveryNoteCollection() ?? new DeliveryNoteCollection([]);

        if ($command->getId()) {
            try {
                /**
                 * @var DeliveryNote $deliveryNote
                 */
                $oldDeliveryNote = $deliveryNoteCollection->getByProperty($command->getId(), 'id');
            } catch (\Exception $e) {
                throw new \Exception('Delivery note not found in collection', $e->getCode());
            }
            $deliveryNote = $oldDeliveryNote;

            $deliveryNote->setTypeId($command->getTypeId());
            $deliveryNote->setTypeName($command->getTypeName());
            $deliveryNote->setFile($command->getFile());
            $deliveryNote->setDateUpload(new DateTimeValueObject(new DateTime()));

            $deliveryNoteCollection->replaceItem($oldDeliveryNote, $deliveryNote);
        } else {
            $deliveryNoteCollection->add(new DeliveryNote(
                null,
                $command->getTypeId(),
                $command->getTypeName(),
                $command->getFile(),
                new DateTimeValueObject(new DateTime())
            ));
        }

        $movement->setDeliveryNoteCollection($deliveryNoteCollection);

        $response = $this->movementRepository->update($movement);

        return new UpdateDeliveryNotesMovementResponse(
            $response->getOperationResponse()->wasSuccess(),
            $response->getOperationResponse()->getCode(),
            $response->getOperationResponse()->getMessage()
        );
    }
}
