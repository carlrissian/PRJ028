<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Application\ShowCarGroup;

use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

/**
 * Class ShowCarGroupQueryHandler
 * @package Distribution\CarGroup\Application\ShowCarGroup
 */
class ShowCarGroupQueryHandler
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


    public function handle(ShowCarGroupQuery $query): ShowCarGroupResponse
    {
       $carGroupId = $query->getId();

       $carGroup = $this->carGroupRepository->getById($carGroupId);

        $acrissFilterCollection = new FilterCollection([]);
        $acrissResponse = $this->acrissRepository->getBy(new AcrissCriteria($acrissFilterCollection));

        $acrissFiltered = array_filter($acrissResponse->getCollection()->toArray(), function ($acriss) use ($carGroup){
            return $acriss->getCarGroup() && $acriss->getCarGroup()->getId() == $carGroup->getId();
        });

        $acrissName = '';
        foreach ($acrissFiltered as $acriss) {
            $acrissName .= $acriss->getAcrissName() . ', ';
        }
        $acrissName = substr($acrissName, 0, -2);

       $carGroupResponse = [
           'id' => $carGroup->getId(),
           'name' => $carGroup->getName(),
           'acrissName' => $acrissName,
           'status' => $carGroup->isEnabled(),
       ];

       return new ShowCarGroupResponse($carGroupResponse);
    }

}
