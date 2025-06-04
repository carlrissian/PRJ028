<?php
declare(strict_types=1);


namespace Distribution\VehicleType\Domain;


interface VehicleTypeRepository
{
    /**
     * @param VehicleTypeCriteria $criteria
     * @return VehicleTypeGetByResponse
     */
    public function getBy(VehicleTypeCriteria $criteria): VehicleTypeGetByResponse;
}