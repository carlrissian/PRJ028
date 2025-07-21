<?php

namespace Distribution\VehicleSeats\Domain;

interface VehicleSeatsRepositoryInterface
{
    /**
     * @param VehicleSeatsCriteria $criteria
     * @return VehicleSeatsGetByResponse
     */
    public function getBy(VehicleSeatsCriteria $criteria): VehicleSeatsGetByResponse;
}
