<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\FilterAcriss;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Distribution\Acriss\Domain\Acriss;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\CommercialGroup\Domain\CommercialGroupCollection;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;
class FilterAcrissQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    /**
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository, CommercialGroupRepository $commercialGroupRepository)
    {
        $this->acrissRepository = $acrissRepository;
        $this->commercialGroupRepository = $commercialGroupRepository;
    }

    /**
     * @param FilterAcrissQuery $query
     * @return FilterAcrissResponse
     */
    public function handle(FilterAcrissQuery $query): FilterAcrissResponse
    {
        $acrissCriteria = $this->setAcrissCriteria($query);
        $response = $this->acrissRepository->getBy($acrissCriteria);

        // TODO: OBTENER COMERCIALGROUP DE ESTRUCTURA ACRISS
        // $acrissIds = array_map(function ($acriss) {
        //     return $acriss->getId();
        // }, $response->getCollection()->toArray());
        // $commercialGroupCriteria = $this->setCommercialGroupCriteria($query, $acrissIds);
        // $commercialGroupCollection = $this->commercialGroupRepository->getBy($commercialGroupCriteria)->getCollection();
        $commercialGroupCollection = new CommercialGroupCollection([]);

        $acrissList = [];
        $acrissIdsAdded = [];
        /**
         * @var Acriss $acriss
         */
        foreach ($response->getCollection()->toArray() as $acriss) {
            if (in_array($acriss->getId(), $acrissIdsAdded) || $acriss->getAcrissParentId() !== null) {
                continue;
            } else {
                $commercialGroupIds = [];
                $commercialGroupName = [];
                $commercialGroupAcrissIds = [];
                $acrissIdList = [];

                foreach ($commercialGroupCollection as $commercialGroup) {
                    $commercialGroupAcrissCollection = $commercialGroup->getAcriss();
                    $isAcrissCommercialGroup = false;
                    foreach ($commercialGroupAcrissCollection as $commercialGroupAcriss) {

                        if (!in_array($commercialGroupAcriss->getId(), $acrissIdList)) {
                            $acrissIdList[] = $commercialGroupAcriss->getId();
                        }

                        if ($commercialGroupAcriss->getId() == $acriss->getId()) {
                            $commercialGroupName[] = $commercialGroup->getName();
                            $commercialGroupIds[] = $commercialGroup->getId();
                            $isAcrissCommercialGroup = true;
                        }
                    }
                    if ($isAcrissCommercialGroup && !empty($acrissIdList)) {
                        $commercialGroupAcrissIds[$commercialGroup->getId()] = $acrissIdList;
                        $acrissIdList = [];
                    }
                }
            }

            $acrissList[] = [
                'id' => $acriss->getId(),
                'name' => $acriss->getName(),
                'carClass' => $acriss->getCarClass()->getName(),
                'acrissType' => $acriss->getAcrissType()->getName(),
                'gearBox' => $acriss->getGearBox()->getName(),
                'motorizationType' => $acriss->getMotorizationType()->getName(),
                'commercialGroup' => [],
                'carGroup' => $acriss->getCarGroup() ? $acriss->getCarGroup()->getName() : null,
                'status' => $acriss->isEnabled(),
            ];
        }

        return new FilterAcrissResponse($acrissList, $response->getTotalRows());
    }


    /**
     * @param FilterAcrissQuery $query
     * @return AcrissCriteria
     */
    private function setAcrissCriteria(FilterAcrissQuery $query): AcrissCriteria
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getCommercialGroupIds()) $filterCollection->add(new Filter('COMMERCIALGROUPIDIN', new FilterOperator(FilterOperator::IN), $query->getCommercialGroupIds()));

        if ($query->getCarGroupIds()) $filterCollection->add(new Filter('VHICLEGROUPIDIN', new FilterOperator(FilterOperator::IN), $query->getCarGroupIds()));

        if ($query->getCarClassIds()) $filterCollection->add(new Filter('CARCLASSIDIN', new FilterOperator(FilterOperator::IN), $query->getCarClassIds()));

        if ($query->getAcrissName()) $filterCollection->add(new Filter('ACRISSCODE', new FilterOperator(FilterOperator::EQUAL), $query->getAcrissName()));

        if ($query->getMotorizationTypeIds()) $filterCollection->add(new Filter('MOTORTYPEIDIN', new FilterOperator(FilterOperator::IN), $query->getMotorizationTypeIds()));

        if ($query->getGearBoxIds()) $filterCollection->add(new Filter('GEARBOXIDIN', new FilterOperator(FilterOperator::IN), $query->getGearBoxIds()));

        if ($query->getAcrissStatus() !== null) $filterCollection->add(new Filter('ENABLED', new FilterOperator(FilterOperator::EQUAL), $query->getAcrissStatus() ? 1 : 0));


        $sortCollection = null;
        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        return new AcrissCriteria($filterCollection, $pagination);
    }

    /**
     * @param FilterAcrissQuery $query
     * @param array|null $acrissIds
     * @return CommercialGroupCriteria
     */
    private function setCommercialGroupCriteria(FilterAcrissQuery $query, ?array $acrissIds): CommercialGroupCriteria
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getCommercialGroupIds()) $filterCollection->add(new Filter('COMMERCIALGROUPIDIN', new FilterOperator(FilterOperator::IN), $query->getCommercialGroupIds()));

        if ($acrissIds) $filterCollection->add(new Filter('ACRISSIDIN', new FilterOperator(FilterOperator::IN), $acrissIds));


        $sortCollection = null;
        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        return new CommercialGroupCriteria($filterCollection, $pagination);
    }
}