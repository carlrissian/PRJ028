<?php

namespace Distribution\Vehicle\Application\SearchVehicle;

use Distribution\Vehicle\Domain\Vehicle;

class SearchVehicleResponse
{
    /**
     * @var bool
     */
    private $exist;

    /**
     * @var Vehicle|null
     */
    private $vehicle;

    /**
     * SearchVehicleResponse constructor
     * 
     * @param bool $exist
     * @param Vehicle|null $vehicle
     */
    public function __construct(bool $exist, ?Vehicle $vehicle = null)
    {
        $this->exist = $exist;
        $this->vehicle = $vehicle;
    }

    /**
     * @return bool
     */
    public function doesExist(): bool
    {
        return $this->exist;
    }

    /**
     * @return Vehicle|null
     */
    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }
}
