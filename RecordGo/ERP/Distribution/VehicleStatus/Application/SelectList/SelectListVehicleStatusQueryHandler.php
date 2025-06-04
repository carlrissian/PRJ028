<?php

namespace Distribution\VehicleStatus\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\VehicleStatus\Domain\VehicleStatusCriteria;
use Distribution\VehicleStatus\Domain\VehicleStatusRepository;

class SelectListVehicleStatusQueryHandler
{
    /**
     * @var VehicleStatusRepository
     */
    private VehicleStatusRepository $vehicleStatusRepository;

    /**
     * SelectListVehicleStatusQueryHandler constructor
     * 
     * @param VehicleStatusRepository $vehicleStatusRepository
     */
    public function __construct(VehicleStatusRepository $vehicleStatusRepository)
    {
        $this->vehicleStatusRepository = $vehicleStatusRepository;
    }

    /**
     * @return SelectListVehicleStatusResponse
     */
    public function handle(): SelectListVehicleStatusResponse
    {
        $vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection();
        return new SelectListVehicleStatusResponse(Utils::createSelect($vehicleStatusCollection));
    }
}
