<?php

namespace Distribution\Movement\Application\DeleteDeliveryNotes;


class DeleteDeliveryNotesCommand
{
    /**
     * @var int
     */
    private $movementId;

    /**
     * @var int
     */
    private $id;

    /**
     * DeleteDeliveryNotesMovementCommand constructor.
     *
     * @param int $movementId
     * @param int $id
     */
    public function __construct(int $movementId, int $id)
    {
        $this->movementId = $movementId;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
