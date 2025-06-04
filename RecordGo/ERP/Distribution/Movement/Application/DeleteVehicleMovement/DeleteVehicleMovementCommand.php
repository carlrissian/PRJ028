<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\DeleteVehicleMovement;

class DeleteVehicleMovementCommand
{
    /**
     * @var int
     */
    private int $movementId;

    /**
     * @var array
     */
    private array $vehicleIdList;

    /**
     * DeleteVehicleMovementCommand constructor.
     * 
     * @param int $movementId
     * @param array $vehicleIdList
     */
    public function __construct(int $movementId, array $vehicleIdList)
    {
        $this->movementId = $movementId;
        $this->vehicleIdList = $vehicleIdList;
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
    public function getVehicleIdList(): array
    {
        return $this->vehicleIdList;
    }
}
