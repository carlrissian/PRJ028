<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\ShowVehicle;

use Distribution\Vehicle\Domain\VehicleCriteria;
use Exception;
use Distribution\Vehicle\Domain\VehicleRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class ShowVehicleQueryHandler
{
    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * ShowVehicleQueryHandler constructor
     * 
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @param ShowVehicleQuery $query
     * @return ShowVehicleResponse
     */
    public function handle(ShowVehicleQuery $query): ShowVehicleResponse
    {
        // INFO en el getById no se reciben algunos datos, como SaleMethod
        // $vehicle = $this->vehicleRepository->getById($query->getId());

        $vehicle = $this->vehicleRepository->getBy(
            new VehicleCriteria(new FilterCollection([new Filter('LICENSEPLATE', new FilterOperator(FilterOperator::EQUAL), $query->getLicensePlate())]))
        )->getCollection()->toArray()[0];


        if (empty($vehicle)) {
            throw new Exception('Error getting Vehicle');
        }

        return new ShowVehicleResponse($vehicle);
    }
}
