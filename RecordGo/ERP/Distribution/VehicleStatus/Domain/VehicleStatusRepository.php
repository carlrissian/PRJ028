<?php

declare(strict_types=1);

namespace Distribution\VehicleStatus\Domain;

interface VehicleStatusRepository
{
    /**
     * @param VehicleStatusCriteria $vehicleStatusCriteria
     * @return VehicleStatusGetByResponse
     */
    public function getBy(VehicleStatusCriteria $vehicleStatusCriteria): VehicleStatusGetByResponse;

    /**
     * @param integer $id
     * @return VehicleStatus|null
     */
    // public function getById(int $id): ?VehicleStatus;
}
