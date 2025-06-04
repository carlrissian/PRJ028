<?php

declare(strict_types=1);


namespace Distribution\Movement\Application\ListVehicle;


class ListVehicleResponse
{
    /**
     * @var array
     */
    private $movement;

    /**
     * ListVehicleResponse constructor.
     * 
     * @param array $movement
     */
    public function __construct(array $movement)
    {
        $this->movement = $movement;
    }

    /**
     * @return array
     */
    public function getMovement(): array
    {
        return $this->movement;
    }
}
