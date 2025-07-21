<?php

namespace Distribution\VehicleSeats\Application\SelectList;

use Distribution\VehicleSeats\Domain\VehicleSeats;
use Distribution\VehicleSeats\Domain\VehicleSeatsCriteria;
use Distribution\VehicleSeats\Domain\VehicleSeatsRepositoryInterface;

class SelectListVehicleSeatsQueryHandler
{
    /**
     * @var VehicleSeatsRepositoryInterface
     */
    private $vehicleSeatsRepository;

    /**
     * SelectListVehicleSeatsQueryHandler constructor.
     *
     * @param VehicleSeatsRepositoryInterface $vehicleSeatsRepository
     */
    public function __construct(VehicleSeatsRepositoryInterface $vehicleSeatsRepository)
    {
        $this->vehicleSeatsRepository = $vehicleSeatsRepository;
    }

    /**
     * @return SelectListVehicleSeatsResponse
     */
    public function handle(): SelectListVehicleSeatsResponse
    {
        $vehicleSeatsCollection = $this->vehicleSeatsRepository->getBy(new VehicleSeatsCriteria())->getCollection();

        $vehicleSeatsSelectList = [];
        foreach ($vehicleSeatsCollection as $vehicleSeats) {
            /**
             * @var VehicleSeats $vehicleSeats
             */
            $vehicleSeatsSelectList[] = [
                'id' => $vehicleSeats->getId(),
                'name' => $vehicleSeats->getValue(),
            ];
        }

        return new SelectListVehicleSeatsResponse($vehicleSeatsSelectList);
    }
}
