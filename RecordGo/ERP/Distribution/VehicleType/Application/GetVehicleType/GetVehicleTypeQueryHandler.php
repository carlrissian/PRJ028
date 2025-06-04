<?php
declare(strict_types=1);


namespace Distribution\VehicleType\Application\GetVehicleType;


use Distribution\VehicleType\Domain\VehicleTypeCriteria;
use Distribution\VehicleType\Domain\VehicleTypeNotFoundException;
use Distribution\VehicleType\Domain\VehicleTypeRepository;

class GetVehicleTypeQueryHandler
{
    /**
     * @var VehicleTypeRepository
     */
    private VehicleTypeRepository $vehicleTypeRepository;

    public function __construct(VehicleTypeRepository $vehicleTypeRepository)
    {
        $this->vehicleTypeRepository = $vehicleTypeRepository;
    }

    /**
     * @throws VehicleTypeNotFoundException
     */
    public function handle(GetVehicleTypeQuery $query): GetVehicleTypeResponse
    {
        $vehicleTypeCollection = $this->vehicleTypeRepository->getBy(new VehicleTypeCriteria())->getCollection();
        if (empty( $vehicleTypeCollection ) ){
            throw new VehicleTypeNotFoundException('Error getting vehicleTypeCollection');
        }
        $vehicleTypeList = [];
        foreach ($vehicleTypeCollection as $vehicleType){
            $vehicleTypeList[] = [
                'id' =>   $vehicleType->getId(),
                'name' => $vehicleType->getName()
            ];
        }
        return new GetVehicleTypeResponse($vehicleTypeList);
    }
}