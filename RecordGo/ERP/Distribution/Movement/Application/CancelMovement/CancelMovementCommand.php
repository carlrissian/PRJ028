<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CancelMovement;

class CancelMovementCommand
{
    /**
     * @var int
     */
    private int $movementId;

    /**
     * @var string
     */
    private string $cancelationNotes;

    /**
     * CancelMovementCommand constructor.
     * 
     * @param int $movementId
     * @param string $cancelationNotes
     */
    public function __construct(int $movementId, string $cancelationNotes)
    {
        $this->movementId = $movementId;
        $this->cancelationNotes = $cancelationNotes;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

    /**
     * @return string
     */
    public function getCancelationNotes(): string
    {
        return $this->cancelationNotes;
    }
}
