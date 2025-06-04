<?php

namespace Distribution\Vehicle\Application\SearchVehicle;

use Shared\Domain\Criteria\Filter;
use Distribution\Branch\Domain\Branch;
use Distribution\Vehicle\Domain\Vehicle;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Vehicle\Domain\VehicleCriteria;
use Distribution\Vehicle\Domain\VehicleRepository;
use Distribution\Vehicle\Domain\VehicleNotFoundException;

class SearchVehicleQueryHandler
{
    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    /**
     * @var BranchRepository
     */
    private $branchRepository;

    /**
     * SearchVehicleQueryHandler constructor
     *
     * @param VehicleRepository $vehicleRepository
     * @param BranchRepository $branchRepository
     */
    public function __construct(VehicleRepository $vehicleRepository, BranchRepository $branchRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->branchRepository = $branchRepository;
    }

    /**
     * @param SearchVehicleQuery $query
     * @return SearchVehicleResponse
     * @throws VehicleNotFoundException
     */
    final public function handle(SearchVehicleQuery $query): SearchVehicleResponse
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getLicensePlate() === null && $query->getVin() === null) {
            throw new VehicleNotFoundException('Error searching vehicle', []);
        } else {
            $filterCollection->add(new Filter('LICENSEPLATE', new FilterOperator(FilterOperator::EQUAL), $query->getLicensePlate()));
            $filterCollection->add(new Filter('VIN', new FilterOperator(FilterOperator::EQUAL), $query->getVin()));
        }

        $criteria = new VehicleCriteria($filterCollection);
        /**
         * @var Vehicle $vehicle
         */
        $vehicle = $this->vehicleRepository->getBy($criteria)->getCollection()[0] ?? null;

        if (!empty($vehicle) && !empty($vehicle->getBranch())) {
            // TODO BRANCHGROUPID TIENE QUE LLEGAR EN RESPONSE DE REPOSITORIO
            /**
             * @var Branch $branch
             */
            $branch = $this->branchRepository->getById($vehicle->getBranch()->getId());
            if ($branch->getBranchGroupId()) $vehicle->getBranch()->setBranchGroupId($branch->getBranchGroupId());
        }

        return new SearchVehicleResponse(!!$vehicle, $vehicle);
    }
}
