<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\GetExternalLocations;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationRepository;

class GetExternalLocationsQueryHandler
{
    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;

    /**
     * GetExternalLocationsQueryHandler constructor.
     * 
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param GetExternalLocationsQuery $query
     * @return GetExternalLocationsResponse
     */
    public function handle(GetExternalLocationsQuery $query): GetExternalLocationsResponse
    {
        $filterCollection = new FilterCollection([]);

        if (!empty($query->getProviderId())) $filterCollection->add(new Filter('PROVIDERID', new FilterOperator(FilterOperator::EQUAL), $query->getProviderId()));

        $externalLocationCollection = $this->locationRepository->getBy(new LocationCriteria($filterCollection))->getCollection();

        $externalLocationList = [];
        if ($externalLocationCollection->count() > 0) {
            // $externalLocationList = Utils::createSelect($externalLocationCollection);
            /**
             * @var Location $location
             */
            foreach ($externalLocationCollection as $location) {
                $externalLocationList[] = [
                    'id' => $location->getId(),
                    'name' => $location->getName(),
                    'branchId' => ($location->getBranch()) ? $location->getBranch()->getId() : null,
                    'branchIATA' => ($location->getBranch()) ? $location->getBranch()->getBranchIATA() : null,
                    'branchGroupId' => ($location->getBranch()) ? $location->getBranch()->getBranchGroupId() : null
                ];
            }
        }

        return new GetExternalLocationsResponse($externalLocationList);
    }
}
