<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\ListVehicleAnticipations;

class ListVehicleAnticipationsQuery
{
    /**
     * @var int
     */
    private int $vehicleId;

    /**
     * ListVehicleAnticipationsQuery constructor.
     * 
     * @param int $vehicleId
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
