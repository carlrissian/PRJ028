<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\FilterVehicleHistory;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Vehicle\Domain\VehicleRepository;
use Distribution\Vehicle\Domain\VehicleHistoryCriteria;

class FilterVehicleHistoryQueryHandler
{
    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * FilterVehicleHistoryHandler constructor.
     * 
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @param FilterVehicleHistoryQuery $query
     * @return FilterVehicleHistoryResponse
     */
    public function handle(FilterVehicleHistoryQuery $query): FilterVehicleHistoryResponse
    {
        $criteria = $this->setCriteria($query);
        $response = $this->vehicleRepository->getVehicleHistoryBy($criteria);

        return new FilterVehicleHistoryResponse($response->getCollection()->toArray(), $response->getTotalRows());
    }


    /**
     * @param FilterVehicleHistoryQuery $query
     * @return VehicleHistoryCriteria
     */
    private function setCriteria(FilterVehicleHistoryQuery $query): VehicleHistoryCriteria
    {
        $filterCollection = new FilterCollection([]);

        $filterCollection->add(new Filter('VEHICLEID', new FilterOperator(FilterOperator::EQUAL), $query->getVehicleId()));

        if ($query->getOriginStatusId()) $filterCollection->add(new Filter('VEHICLESTATUSORIGINID', new FilterOperator(FilterOperator::EQUAL), $query->getOriginStatusId()));

        if ($query->getEndStatusId()) $filterCollection->add(new Filter('VEHICLESTATUSENDID', new FilterOperator(FilterOperator::EQUAL), $query->getEndStatusId()));

        if ($query->getStatusChangeDateFrom()) $filterCollection->add(new Filter('STATUSCHANGEDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($query->getStatusChangeDateFrom())));

        if ($query->getStatusChangeDateTo()) $filterCollection->add(new Filter('STATUSCHANGEDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatDateToLastMinuteDateTime($query->getStatusChangeDateTo())));


        $sortCollection = null;
        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        return new VehicleHistoryCriteria($filterCollection, $pagination);
    }
}
