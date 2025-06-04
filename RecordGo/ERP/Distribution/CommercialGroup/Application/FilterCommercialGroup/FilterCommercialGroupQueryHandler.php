<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\FilterCommercialGroup;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\CommercialGroup\Domain\CommercialGroup;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;

class FilterCommercialGroupQueryHandler
{
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    /**
     * GetCommercialGroupHandler constructor.
     * 
     * @param CommercialGroupRepository $commercialGroupRepository
     */
    public function __construct(CommercialGroupRepository $commercialGroupRepository)
    {
        $this->commercialGroupRepository = $commercialGroupRepository;
    }

    /**
     * @param FilterCommercialGroupQuery $query
     * @return FilterCommercialGroupResponse
     */
    public function handle(FilterCommercialGroupQuery $query): FilterCommercialGroupResponse
    {
        $pagination = new Pagination($query->getLimit(), $query->getOffset());

        $response = $this->commercialGroupRepository->getBy(new CommercialGroupCriteria($this->setCriteria($query), $pagination));

        $responseArray = [];
        /**
         * @var CommercialGroup $commercialGroup
         */
        foreach ($response->getCollection() as $commercialGroup) {
            $responseArray[] = [
                'id' => $commercialGroup->getId(),
                'name' => $commercialGroup->getName(),
                'acrissName' => $commercialGroup->getAcrissName(),
                'status' => $commercialGroup->isActive()
            ];
        }
        return new FilterCommercialGroupResponse($responseArray, $response->getTotalRows());
    }

    /**
     * @param FilterCommercialGroupQuery $query
     * @return FilterCollection
     */
    private function setCriteria(FilterCommercialGroupQuery $query): FilterCollection
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getCommercialGroupIds()) $filterCollection->add(new Filter('COMMERCIALGROUPID', new FilterOperator(FilterOperator::IN), $query->getCommercialGroupIds()));

        if ($query->getAcrissName()) $filterCollection->add(new Filter('ACRISS', new FilterOperator(FilterOperator::EQUAL), $query->getAcrissName()));

        if (is_bool($query->isActive())) $filterCollection->add(new Filter('STATUS', new FilterOperator(FilterOperator::EQUAL), $query->isActive()));

        return $filterCollection;
    }
}
