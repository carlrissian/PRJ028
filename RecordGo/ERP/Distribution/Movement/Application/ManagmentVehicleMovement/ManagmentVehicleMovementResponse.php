<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\ManagmentVehicleMovement;

class ManagmentVehicleMovementResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * @var array
     */
    private array $movement;

    /**
     * ManagmentVehicleMovementResponse constructor.
     *
     * @param array $selectList
     * @param array $movement
     */
    public function __construct(
        array $selectList,
        array $movement
    ) {
        $this->selectList = $selectList;
        $this->movement = $movement;
    }

    /**
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }

    /**
     * @return array
     */
    public function getMovement(): array
    {
        return $this->movement;
    }
}
