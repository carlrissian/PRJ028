<?php

namespace Distribution\VehicleType\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\VehicleType\Domain\VehicleTypeCriteria;
use Distribution\VehicleType\Domain\VehicleTypeRepository;

class SelectListVehicleTypeQueryHandler
{
    /**
     * @var VehicleTypeRepository
     */
    private $vehicleTypeRepository;

    /**
     * SelectListVehicleTypeQueryHandler constructor.
     *
     * @param VehicleTypeRepository $vehicleTypeRepository
     */
    public function __construct(VehicleTypeRepository $vehicleTypeRepository)
    {
        $this->vehicleTypeRepository = $vehicleTypeRepository;
    }

    /**
     * @return SelectListVehicleTypeResponse
     */
    public function handle(): SelectListVehicleTypeResponse
    {
        $vehicleTypeCollection = $this->vehicleTypeRepository->getBy(new VehicleTypeCriteria())->getCollection();
        return new SelectListVehicleTypeResponse(Utils::createSelect($vehicleTypeCollection));
    }
}
