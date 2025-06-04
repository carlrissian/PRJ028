<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\ListVehicleAnticipations;

class ListVehicleAnticipationsResponse
{
    /**
     * @var array
     */
    private array $vehicleAnticipationResponse;

    /**
     * ListVehicleAnticipationsResponse constructor.
     * 
     * @param array $vehicleAnticipationResponse
     */
    public function __construct(array $vehicleAnticipationResponse)
    {
        $this->vehicleAnticipationResponse = $vehicleAnticipationResponse;
    }

    /**
     * @return array
     */
    public function getVehicleAnticipationResponse(): array
    {
        return $this->vehicleAnticipationResponse;
    }
}
