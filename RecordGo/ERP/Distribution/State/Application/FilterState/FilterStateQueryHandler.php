<?php

namespace Distribution\State\Application\FilterState;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\State\Domain\StateCriteria;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\State\Domain\StateRepository;

class FilterStateQueryHandler
{
    /**
     * @var StateRepository
     */
    private StateRepository $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function handle(FilterStateQuery $query, $selectList = false): FilterStateResponse
    {
        $sortCollection = null;
        $pagination = null;
        // TODO si en algún momento se pide orden y limite, descomentar
        // if (!empty($query->getSort()) && !empty($query->getOrder())) {
        //     $sortCollection = new SortCollection([
        //         new Sort($query->getSort(), $query->getOrder())
        //     ]);
        // }
        // $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        $filterCollection = $this->setCriteria($query);
        $criteria = new StateCriteria($filterCollection, $pagination);
        $stateCollection = $this->stateRepository->getBy($criteria)->getCollection();

        $stateArray = [];
        if ($selectList) {
            $stateArray = Utils::createSelect($stateCollection);
        } else {
            foreach ($stateCollection as $state) {
                $stateArray[] = $state->toArray();
            }
        }

        return new FilterStateResponse($stateArray);
    }


    /**
     * @param FilterVehicleQuery $query
     * @return FilterCollection
     */
    private function setCriteria(FilterStateQuery $query): FilterCollection
    {
        $filterCollection = new FilterCollection([]);

        if (!empty($query->getCountryId())) $filterCollection->add(new Filter('COUNTRYID', new FilterOperator(FilterOperator::EQUAL), $query->getCountryId()));

        return $filterCollection;
    }
}
