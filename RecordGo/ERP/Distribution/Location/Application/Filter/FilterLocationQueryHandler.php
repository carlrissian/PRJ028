<?php

namespace Distribution\Location\Application\Filter;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Distribution\Location\Domain\Location;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\BranchGroup\Domain\BranchGroup;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationRepository;
use Distribution\BranchGroup\Domain\BranchGroupCriteria;
use Distribution\BranchGroup\Domain\BranchGroupRepository;
use Distribution\Location\Domain\BranchGroup as LocationBranchGroup;

class FilterLocationQueryHandler
{
    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var BranchGroupRepository
     */
    private $branchGroupRepository;

    /**
     * @param LocationRepository $locationRepository
     * @param BranchGroupRepository $branchGroupRepository
     */
    public function __construct(LocationRepository $locationRepository, BranchGroupRepository $branchGroupRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->branchGroupRepository = $branchGroupRepository;
    }

    /**
     * @param FilterLocationQuery $query
     * @return FilterLocationResponse
     */
    public function handle(FilterLocationQuery $query): FilterLocationResponse
    {
        $response = $this->locationRepository->getBy($this->setCriteria($query));
        $locationCollection = $response->getCollection();
        $branchGroupCollection = $this->branchGroupRepository->getBy(new BranchGroupCriteria())->getCollection();

        /**
         * @var Location $location
         */
        foreach ($locationCollection as $location) {
            if ($location->getBranch() && $location->getBranch()->getBranchGroupId()) {
                try {
                    /**
                     * @var BranchGroup $branchGroup
                     */
                    $branchGroup = $branchGroupCollection->getByProperty($location->getBranch()->getBranchGroupId(), 'id');

                    $location->setBranchGroup(new LocationBranchGroup($branchGroup->getId(), $branchGroup->getName()));
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return new FilterLocationResponse($locationCollection->toArray(), $response->getTotalRows());
    }

    /**
     * @param FilterLocationQuery $query
     * @return LocationCriteria
     */
    private function setCriteria(FilterLocationQuery $query): LocationCriteria
    {
        $sortCollection = null;
        $filterCollection = new FilterCollection([]);

        if (!empty($query->hasPartner())) $filterCollection->add(new Filter('HASPARTNER', new FilterOperator(FilterOperator::EQUAL), $query->hasPartner() ? 1 : 0));


        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);
        $criteria = new LocationCriteria($filterCollection, $pagination);

        return $criteria;
    }
}
