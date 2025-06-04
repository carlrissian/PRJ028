<?php

namespace Distribution\Movement\Application\DeleteDeliveryNotes;

class DeleteDeliveryNotesMovementResponse
{
    /**
     * @var bool
     */
    private bool $deleted;

    /**
     * DeleteDeliveryNotesMovementResponse constructor.
     * 
     * @param bool $deleted
     */
    public function __construct(bool $deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }
}
