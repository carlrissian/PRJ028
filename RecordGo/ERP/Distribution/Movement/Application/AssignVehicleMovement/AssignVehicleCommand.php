<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\AssignVehicleMovement;


class AssignVehicleCommand
{
    /**
     * @var array
     */
    private array $vehiclesId;
    /**
     * @var int
     */
    private int $vehiclesUnits;
    /**
     * @var int
     */
    private int $movementId;

    /**
     * AssignVehicleCommand constructor.
     * @param array $vehiclesId
     * @param int $vehiclesUnits
     * @param int $movementId
     */
    public function __construct(array $vehiclesId, int $vehiclesUnits, int $movementId)
    {
        $this->vehiclesId = $vehiclesId;
        $this->vehiclesUnits = $vehiclesUnits;
        $this->movementId = $movementId;
    }

    /**
     * @return array
     */
    public function getVehiclesId(): array
    {
        return $this->vehiclesId;
    }

    /**
     * @return int
     */
    public function getVehiclesUnits(): int
    {
        return $this->vehiclesUnits;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }


}