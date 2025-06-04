<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\ShowVehicle;

class ShowVehicleQuery
{
    /**
     * @var string
     */
    private string $licensePlate;

    /**
     * ShowVehicleQuery constructor.
     * 
     * @param string $licensePlate
     */
    public function __construct(string $licensePlate)
    {
        $this->licensePlate = $licensePlate;
    }

    /**
     * @return string
     */
    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }
}
