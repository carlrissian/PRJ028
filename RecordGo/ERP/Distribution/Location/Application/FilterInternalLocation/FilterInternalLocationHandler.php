<?php

declare(strict_types=1);

namespace Distribution\Location\Application\FilterInternalLocation;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationRepository;

class FilterInternalLocationHandler
{
    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;

    /**
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param FilterInternalLocationQuery $query
     * @return FilterInternalLocationResponse
     */
    public function handle(FilterInternalLocationQuery $query): FilterInternalLocationResponse
    {
        $response = $this->locationRepository->getBy(
            new LocationCriteria(
                new FilterCollection([
                    new Filter('HASPARTNER', new FilterOperator(FilterOperator::EQUAL), 0)
                ]),
                new Pagination(
                    $query->getLimit(),
                    $query->getOffset(),
                    new SortCollection(($query->getSort()) ? [new Sort($query->getSort())] : [])
                )
            )
        );

        return new FilterInternalLocationResponse($response->getCollection(), $response->getTotalRows());
    }
}
