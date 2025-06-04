<?php

namespace Distribution\InsurancePolicies\Domain;

interface InsurancePoliciesRepository
{
    /**
     * @param integer $vehicleId
     * @return InsurancePoliciesGetByResponse
     */
    public function getByVehicleId(int $vehicleId): InsurancePoliciesGetByResponse;
}
