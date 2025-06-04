<?php

namespace Distribution\Supplier\Application\FilterSupplier;

use Exception;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Supplier\Domain\SupplierCriteria;
use Distribution\Supplier\Infrastructure\SupplierRepositorySap;

class FilterSupplierQueryHandler
{
    /**
     * @var SupplierRepositorySap
     */
    private $supplierRepository;

    /**
     * FilterSupplierQueryHandler constructor.
     * 
     * @param SupplierRepositorySap $supplierRepository
     */
    public function __construct(SupplierRepositorySap $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * @throws Exception
     */
    public function handle(FilterSupplierQuery $query): FilterSupplierResponse
    {
        $filterCollection = $this->setCriteria($query);

        $sortCollection = null;
        if (!empty($query->getSortBy()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSortBy(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        [$supplierCollection, $totalRows] = $this->supplierRepository->getBy(new SupplierCriteria($filterCollection, $pagination))->toArray();

        return new FilterSupplierResponse($supplierCollection, $totalRows);
    }

    /**
     * @param FilterSupplierQuery $query
     * @return FilterCollection
     */
    private function setCriteria(FilterSupplierQuery $query): FilterCollection
    {
        $filterCollection = new FilterCollection([]);

        if (!empty($query->getId())) $filterCollection->add(new Filter('ID', new FilterOperator(FilterOperator::EQUAL), $query->getId()));

        if (!empty($query->getName())) $filterCollection->add(new Filter('NAMESOCIAL', new FilterOperator(FilterOperator::CONTAINS), $query->getName()));

        if (!empty($query->getVatNumber())) $filterCollection->add(new Filter('VATNUM', new FilterOperator(FilterOperator::CONTAINS), $query->getVatNumber()));

        if (!empty($query->getState())) $filterCollection->add(new Filter('STATEID', new FilterOperator(FilterOperator::EQUAL), $query->getState()));

        return $filterCollection;
    }
}
