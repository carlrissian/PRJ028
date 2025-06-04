<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ValidateMovement;

class ValidateMovementCommand
{
    /**
     * @var int
     */
    private int $movementId;

    /**
     * @var array
     */
    private array $vehicleLinesId;

    /**
     * @var string|null
     */
    private ?string $actualLoadDate;

    /**
     * @var string|null
     */
    private ?string $actualUnloadDate;

    /**
     * @var string
     */
    private string $action;

    /**
     * ValidateMovementCommand constructor.
     * 
     * @param int $movementId
     * @param array $vehicleLinesId
     * @param string|null $actualLoadDate
     * @param string|null $actualUnloadDate
     * @param string $action
     */
    public function __construct(
        int $movementId,
        array $vehicleLinesId,
        ?String $actualLoadDate,
        ?String $actualUnloadDate,
        String $action
    ) {
        $this->movementId = $movementId;
        $this->vehicleLinesId = $vehicleLinesId;
        $this->actualLoadDate = $actualLoadDate;
        $this->actualUnloadDate = $actualUnloadDate;
        $this->action = $action;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

    /**
     * @return array
     */
    public function getVehicleLinesId(): array
    {
        return $this->vehicleLinesId;
    }

    /**
     * @return string|null
     */
    public function getActualLoadDate(): ?string
    {
        return $this->actualLoadDate;
    }

    /**
     * @return string|null
     */
    public function getActualUnloadDate(): ?string
    {
        return $this->actualUnloadDate;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
