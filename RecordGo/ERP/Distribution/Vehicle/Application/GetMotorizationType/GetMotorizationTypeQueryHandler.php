<?php

namespace Distribution\Vehicle\Application\GetMotorizationType;

use Distribution\Vehicle\Domain\VehicleRepository;

class GetMotorizationTypeQueryHandler
{
    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @param GetMotorizationTypeQuery $query
     * @return GetMotorizationTypeResponse
     */
    public function handle(GetMotorizationTypeQuery $query): GetMotorizationTypeResponse
    {
        $vehicle = $this->vehicleRepository->getById($query->getVehicleId());

        $motorizationType = $vehicle->getMotorizationType() ? [
            'id' => $vehicle->getMotorizationType()->getId(),
            'name' => $vehicle->getMotorizationType()->getName(),
        ] : [];

        return new GetMotorizationTypeResponse($motorizationType);
    }
}
