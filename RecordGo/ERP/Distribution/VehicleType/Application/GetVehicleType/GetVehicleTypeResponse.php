<?php
declare(strict_types=1);


namespace Distribution\VehicleType\Application\GetVehicleType;

class GetVehicleTypeResponse
{
    /**
     * @var array
     */
    private array $vehicleTypeList;

    /**
     * GetVehicleTypeResponse constructor.
     * @param array $vehicleTypeList
     */
    public function __construct(array $vehicleTypeList)
    {
        $this->vehicleTypeList = $vehicleTypeList;
    }

    /**
     * @return array
     */
    public function getVehicleTypeList(): array
    {
        return $this->vehicleTypeList;
    }

}