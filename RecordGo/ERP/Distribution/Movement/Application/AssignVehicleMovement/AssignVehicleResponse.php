<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\AssignVehicleMovement;

class AssignVehicleResponse
{
    /**
     * @var bool
     */
    private bool $assigned;
    /**
     * @var string|null
     */
    private ?string $message;

    /**
     * AssignVehicleResponse constructor.
     * 
     * @param bool $assigned
     */
    public function __construct(bool $assigned, ?string $message = null)
    {
        $this->assigned = $assigned;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function areAssigned(): bool
    {
        return $this->assigned;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
