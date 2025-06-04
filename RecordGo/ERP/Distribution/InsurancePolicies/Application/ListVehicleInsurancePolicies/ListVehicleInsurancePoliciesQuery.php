<?php

namespace Distribution\InsurancePolicies\Application\ListVehicleInsurancePolicies;

class ListVehicleInsurancePoliciesQuery
{
    /**
     * @var integer
     */
    private int $vehicleId;

    /**
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
