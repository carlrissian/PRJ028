<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\FilterAssociateAcriss;


use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Pagination\Pagination;

class FilterAssociateQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * GetAcrissHandler constructor.
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }

    public function handle(FilterAssociateQuery $filterAcrissQuery): FilterAssociateResponse
    {
        $limit = $filterAcrissQuery->getLimit();
        $offset = $filterAcrissQuery->getOffset();

        $acrissFilterCollection = new FilterCollection([]);
        $acrissFilterCollection->add(new Filter('parentId', new FilterOperator(FilterOperator::EQUAL), null));
        $pagination = new Pagination($limit, $offset);

        $acrissCriteria = new AcrissCriteria($acrissFilterCollection, $pagination);
        $response = $this->acrissRepository->getBy($acrissCriteria);

        $acrissArray = [];
        $acrissCollection  = $response->getCollection();

        foreach ($acrissCollection as $acriss){
            $acrissChildsList = [];

            $acrissId = $acriss->getId();

            $acrissName  = $acriss->getName()->__toString();

            $acrissChilds = $acriss->getAcrissInferiorCollection();

            if($acrissChilds !== null){
                foreach ($acrissChilds as $acrissChild){
                    $acrissChildsList[] = [
                        'id' => $acrissChild->getId(),
                        'name' => $acrissChild->getCompleteAcrissName()
                    ];
                }
            }

            $acrissArray[] = [
                'id' => $acrissId,
                'acrissName' => $acrissName,
                'acrissChildList' => $acrissChildsList
            ];
        }

        return new FilterAssociateResponse($acrissArray, $response->getTotalRows());
    }

}