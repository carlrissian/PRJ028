<?php

namespace Distribution\RentalAgreement\Application\ListRentalAgreementByVehicle;

class ListRentalAgreementByVehicleQuery
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
     * @return integer
     */
    public function getVehicleId(): int
    {
        return $this->vehicleId;
    }
}
