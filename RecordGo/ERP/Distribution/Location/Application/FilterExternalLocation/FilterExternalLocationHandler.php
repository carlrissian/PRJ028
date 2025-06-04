<?php

declare(strict_types=1);

namespace Distribution\Location\Application\FilterExternalLocation;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\Location\Domain\LocationRepository;

class FilterExternalLocationHandler
{
    /**
     * @var LocationRepository
     */
    private LocationRepository $externalLocationRepository;

    /**
     * @param LocationRepository $externalLocationRepository
     */
    public function __construct(LocationRepository $externalLocationRepository)
    {
        $this->externalLocationRepository = $externalLocationRepository;
    }

    /**
     * @param FilterExternalLocationQuery $query
     * @return FilterExternalLocationResponse
     */
    public function handle(FilterExternalLocationQuery $query): FilterExternalLocationResponse
    {
        $response = $this->externalLocationRepository->getBy(
            new LocationCriteria(
                new FilterCollection([
                    new Filter('HASPARTNER', new FilterOperator(FilterOperator::EQUAL), 1)
                ]),
                new Pagination(
                    $query->getLimit(),
                    $query->getOffset(),
                    new SortCollection(
                        ($query->getSort()) ? [new Sort((string)$query->getSort())] : []
                    )
                )
            )
        );

        return new FilterExternalLocationResponse($response->getCollection(), $response->getTotalRows());
    }
}
