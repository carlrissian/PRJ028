<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterMovementVehicles;

class FilterMovementVehiclesResponse
{
    /**
     * @var array
     */
    private array $movementVehiclesResponse;

    /**
     * FilterMovementVehiclesResponse constructor.
     * 
     * @param array $vehiclesResponse
     */
    public function __construct(array $vehiclesResponse)
    {
        $this->movementVehiclesResponse = $vehiclesResponse;
    }

    /**
     * @return array
     */
    public function getMovementVehiclesResponse(): array
    {
        return $this->movementVehiclesResponse;
    }
}
