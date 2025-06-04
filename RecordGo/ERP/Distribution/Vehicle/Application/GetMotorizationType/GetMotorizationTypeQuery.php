<?php

namespace Distribution\Vehicle\Application\GetMotorizationType;

class GetMotorizationTypeQuery
{
    /**
     * @var int
     */
    private $vehicleId;

    /**
     * GetMotorizationTypeQuery constructor.
     *
     * @param integer $vehicleId
     */
    public function __construct(int $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }

    /**
     * @return int
     */
    public function getVehicleId(): int
    {
        return $this->vehicleId;
    }
}
