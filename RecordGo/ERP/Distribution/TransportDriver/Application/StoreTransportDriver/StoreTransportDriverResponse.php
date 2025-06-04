<?php

namespace Distribution\TransportDriver\Application\StoreTransportDriver;

class StoreTransportDriverResponse
{
    /**
     * @var array
     */
    private $driverData;

    /**
     * @param array $driverData
     */
    public function __construct(array $driverData)
    {
        $this->driverData = $driverData;
    }

    /**
     * @return array
     */
    public function getDriverData(): array
    {
        return $this->driverData;
    }
}