<?php
declare(strict_types=1);

namespace Distribution\CarGroup\Application\CreateCarGroup;

use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class CreateCarGroupQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }

    /**
     * @param CreateCarGroupQuery $listAcrissQuery
     * @return CreateCarGroupResponse
     */
    public function handle(CreateCarGroupQuery $createCarGroupQuery): CreateCarGroupResponse{


        $acrissFilterCollection = new FilterCollection([]);
        $acrissFilterCollection->add(new Filter('carGroupId', new FilterOperator(FilterOperator::EQUAL), null));

        $acrissCriteria = new AcrissCriteria($acrissFilterCollection);

        $acrissCollection = $this->acrissRepository->getBy($acrissCriteria)->getCollection();

        $acrissList = $this->generateSelect($acrissCollection);

        return new CreateCarGroupResponse($acrissList);
    }

    private function generateSelect($collection){

        $acrissAdded = [];
        foreach ($collection as $item){

            if(!in_array($item->getId(), $acrissAdded)){

                $name = '';
                if($item->getAcrissParentId()!==null) {
                    continue;
                }
                $name = $item->getName();
                $acrissAdded[] = $item->getId();

                $result[] = [
                    'id' => $item->getId(),
                    'name' => $name
                ];
            }
        }

        return $result;

    }
}