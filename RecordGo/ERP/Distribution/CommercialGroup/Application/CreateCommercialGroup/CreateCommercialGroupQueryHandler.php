<?php
declare(strict_types=1);


namespace Distribution\CommercialGroup\Application\CreateCommercialGroup;


use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;


class CreateCommercialGroupQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * GetCommercialGroupHandler constructor.
     * @param CommercialGroupRepository $commercialGroupRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }

    public function handle(CreateCommercialGroupQuery $query): CreateCommercialGroupResponse
    {
        $response = $this->acrissRepository->getBy(new AcrissCriteria());

        $acrissList = $this->generateAcrissList($response->getCollection());

        return new CreateCommercialGroupResponse( $acrissList );
    }


    private function generateAcrissList($collection){

        $result = [];
        //se guarda las ids de acriss para no repetir campos
        foreach ($collection as $item){

            $name = '';
            if($item->getAcrissParentId()!==null) {
                continue;
            }
            $name = $item->getName();

            $result[] = [
                'id' => $item->getId(),
                'name' => $name
            ];
        }

        return $result;

    }
}
