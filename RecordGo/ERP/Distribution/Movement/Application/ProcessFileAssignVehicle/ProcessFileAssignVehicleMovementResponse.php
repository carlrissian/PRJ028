<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ProcessFileAssignVehicle;

class ProcessFileAssignVehicleMovementResponse
{

    /**
     * @var bool
     */
    private $completed;

    /**
     * @var string
     */
    private $messages;

    /**
     * @var array
     */
    private $affectedVehicles;

    /**
     * ProcessFileAssignVehicleMovementResponse constructor.
     *
     * @param boolean $completed
     * @param string $messages
     * @param array $affectedVehicles
     */
    public function __construct(bool $completed, string $messages, array $affectedVehicles)
    {
        $this->completed = $completed;
        $this->messages = $messages;
        $this->affectedVehicles = $affectedVehicles;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * @return string
     */
    public function getMessages(): string
    {
        return $this->messages;
    }

    /**
     * @return array
     */
    public function getAffectedVehicles(): array
    {
        return $this->affectedVehicles;
    }
}
