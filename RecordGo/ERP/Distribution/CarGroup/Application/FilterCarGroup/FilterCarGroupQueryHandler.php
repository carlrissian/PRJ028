<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\FilterCarGroup;


use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Pagination\Pagination;

class FilterCarGroupQueryHandler
{
    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $carGroupRepository;
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @param CarGroupRepository $carGroupRepository
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(CarGroupRepository $carGroupRepository, AcrissRepository $acrissRepository)
    {
        $this->carGroupRepository = $carGroupRepository;
        $this->acrissRepository = $acrissRepository;
    }


    public function handle(FilterCarGroupQuery $query): FilterCarGroupResponse
    {
        $limit = $query->getLimit();
        $offset = $query->getOffset();

        $pagination = null;
        if($limit !== null){
            $pagination = new Pagination($limit, $offset);
        }

        $carGroupFilterCollection = new FilterCollection([]);
        if ($query->getCarGroupList() !== null) {
            $carGroupFilterCollection->add(new Filter('CARGROUPIDIN', new FilterOperator(FilterOperator::IN),
                $query->getCarGroupList()));
        }
        if ($query->getStatus() !== null) {
            $carGroupFilterCollection->add(new Filter('VEHICLEGROUPSTATUS', new FilterOperator(FilterOperator::EQUAL),
                $query->getStatus() === 'true' ? 1 : 0));
        }

        if ($query->getAcrissName() !== null) {
            $carGroupFilterCollection->add(new Filter('ACRISSCODE', new FilterOperator(FilterOperator::EQUAL),
                $query->getAcrissName()));
        }

        $carGroupResponse = $this->carGroupRepository->getBy(new CarGroupCriteria($carGroupFilterCollection, $pagination));

        $acrissFilterCollection = new FilterCollection([]);
        $acrissResponse = $this->acrissRepository->getBy(new AcrissCriteria($acrissFilterCollection));

        $carGroupResponseArray = [];

        foreach($carGroupResponse->getCollection() as $carGroup){

            $acrissFiltered = array_filter($acrissResponse->getCollection()->toArray(), function ($acriss) use ($carGroup){
                return $acriss->getCarGroup() && $acriss->getCarGroup()->getId() == $carGroup->getId();
            });
            $acrissName = '';
            foreach ($acrissFiltered as $acriss) {
                $acrissName .= $acriss->getName() . ', ';
            }

            if($acrissName !== ''){
                $acrissName = substr($acrissName, 0, -2);
            }else{
                $acrissName = '-';
            }

            $carGroupResponseArray[] = [
                'id' => $carGroup->getId(),
                'name' => $carGroup->getName(),
                'acrissName' => $acrissName,
                'status' => $carGroup->isEnabled()
            ];

        }

        return new FilterCarGroupResponse($carGroupResponseArray, $carGroupResponse->getTotalRows());
    }
}