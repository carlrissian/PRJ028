<?php

namespace Distribution\Route\Application\Filter;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\Route\Domain\RouteCriteria;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Route\Domain\RouteRepository;

class FilterRouteQueryHandler
{
    /**
     * @var RouteRepository
     */
    private RouteRepository $routeRepository;

    /**
     * FilterRouteQueryHandler constructor.
     *
     * @param RouteRepository $routeRepository
     */
    public function __construct(RouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    /**
     * @param FilterRouteQuery $query
     * @return FilterRouteResponse
     */
    public function handle(FilterRouteQuery $query): FilterRouteResponse
    {
        $criteria = $this->setCriteria($query);
        $response = $this->routeRepository->getBy($criteria);

        return new FilterRouteResponse($response->getCollection()->toArray(), $response->getTotalRows());
    }


    /**
     * @param FilterRouteQuery $query
     * @return RouteCriteria
     */
    private function setCriteria(FilterRouteQuery $query): RouteCriteria
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getTransportMethodId()) $filterCollection->add(new Filter('TRANSPORTMETHODID', new FilterOperator(FilterOperator::EQUAL), $query->getTransportMethodId()));

        if ($query->getProviderId()) $filterCollection->add(new Filter('TRANSPORTPROVIDERID', new FilterOperator(FilterOperator::EQUAL), $query->getProviderId()));

        if ($query->getOriginBranchId()) $filterCollection->add(new Filter('BRANCHORIGINID', new FilterOperator(FilterOperator::EQUAL), $query->getOriginBranchId()));

        if ($query->getDestinationBranchId()) $filterCollection->add(new Filter('BRANCHDESTINYID', new FilterOperator(FilterOperator::EQUAL), $query->getDestinationBranchId()));

        $sortCollection = null;
        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);
        $criteria = new RouteCriteria($filterCollection, $pagination);

        return $criteria;
    }
}
