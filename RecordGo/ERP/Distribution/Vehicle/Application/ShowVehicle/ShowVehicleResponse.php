<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\ShowVehicle;

use Distribution\Vehicle\Domain\Vehicle;

class ShowVehicleResponse
{
    /**
     * @var Vehicle
     */
    private $vehicle;

    /**
     * ShowVehicleResponse constructor
     * 
     * @param Vehicle $vehicle
     */
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * @return Vehicle
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }
}
