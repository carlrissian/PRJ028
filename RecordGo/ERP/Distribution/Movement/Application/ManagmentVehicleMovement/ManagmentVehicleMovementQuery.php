<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\ManagmentVehicleMovement;


class ManagmentVehicleMovementQuery
{
    /**
     * @var int
     */
    private int $movementId;

    /**
     * ManagmentVehicleMovementQuery constructor.
     * @param int $movementId
     */
    public function __construct(int $movementId)
    {
        $this->movementId = $movementId;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

}