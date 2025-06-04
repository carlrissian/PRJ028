<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


class CheckVehicle
{
    /**
     * @var VehicleLine
     */
    private VehicleLine $vehicleLine;

    /**
     * CheckVehicle constructor.
     * @param VehicleLine $vehicleLine
     */
    public function __construct(VehicleLine $vehicleLine)
    {
        $this->vehicleLine = $vehicleLine;
    }

    /**
     * @return VehicleLine
     */
    public function getVehicleLine(): VehicleLine
    {
        return $this->vehicleLine;
    }


}