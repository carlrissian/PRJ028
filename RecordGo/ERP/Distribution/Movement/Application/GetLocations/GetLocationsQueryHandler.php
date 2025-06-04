<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\GetLocations;

use Shared\Domain\Criteria\Filter;
use Distribution\Location\Domain\Location;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationException;
use Distribution\Location\Domain\LocationRepository;

class GetLocationsQueryHandler
{
    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;

    /**
     * GetLocationsQueryHandler constructor.
     * 
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param GetLocationsQuery $query
     * @return GetLocationsResponse
     * @throws LocationException
     */
    public function handle(GetLocationsQuery $query): GetLocationsResponse
    {
        $filterCollection = new FilterCollection([]);

        if (!empty($query->getTypeLocationArray())) {
            $filterCollection->add(new Filter('LOCATIONTYPEID', new FilterOperator(FilterOperator::IN), $query->getTypeLocationArray()));
        }

        if (!empty($query->getBranchId())) {
            $filterCollection->add(new Filter('BRANCHID', new FilterOperator(FilterOperator::NOT_EQUAL), $query->getBranchId()));
        }

        $filterCollection->add(new Filter('HASPARTNER', new FilterOperator(FilterOperator::EQUAL), 0));

        // Obtenemos las localizaciones sin partner
        $locationCollection = $this->locationRepository->getBy(new LocationCriteria($filterCollection))->getCollection();

        $locationList = [];
        if ($locationCollection->count() > 0) {

            /**
             * @var Location $location
             */
            foreach ($locationCollection as $location) {
                $locationList[] = [
                    'id' => $location->getId(),
                    'name' => $location->getName(),
                    'locationTypeId' => $location->getLocationType() ? $location->getLocationType()->getId() : null,
                    'branchId' => $location->getBranch() ? $location->getBranch()->getId() : null,
                    'branchIATA' => $location->getBranch() ? $location->getBranch()->getBranchIATA() : null,
                    'branchGroupId' => $location->getBranch() ? $location->getBranch()->getBranchGroupId() : null
                ];
            }
        }

        return new GetLocationsResponse($locationList);
    }
}
