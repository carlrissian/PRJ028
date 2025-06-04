<?php

namespace Distribution\Vehicle\Application\SearchVehicle;

class SearchVehicleQuery
{
    /**
     * @var string|null
     */
    private $licensePlate;

    /**
     * @var string|null
     */
    private $vin;

    /**
     * SearchVehicleQuery constructor
     * 
     * @param string|null $licensePlate
     * @param string|null $vin
     */
    public function __construct(?string $licensePlate, ?string $vin)
    {
        $this->licensePlate = $licensePlate;
        $this->vin = $vin;
    }

    /**
     * @return string|null
     */
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }

    /**
     * @return string|null
     */
    public function getVin()
    {
        return $this->vin;
    }
}
