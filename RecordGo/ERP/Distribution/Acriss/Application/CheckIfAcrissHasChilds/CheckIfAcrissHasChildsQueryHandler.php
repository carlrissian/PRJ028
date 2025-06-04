<?php

namespace Distribution\Acriss\Application\CheckIfAcrissHasChilds;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;

class CheckIfAcrissHasChildsQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private $acrissRepository;

    /**
     * CheckIfAcrissHasChildsQueryHandler constructor.
     *
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }

    /**
     * @param CheckIfAcrissHasChildsQuery $query
     * @return CheckIfAcrissHasChildsResponse
     */
    public function handle(CheckIfAcrissHasChildsQuery $query): CheckIfAcrissHasChildsResponse
    {
        $criteria = new AcrissCriteria(new FilterCollection([
            new Filter('ACRISSFIRSTLETTER', new FilterOperator(FilterOperator::EQUAL), $query->getAcrissFirstLetter()),
            new Filter('ACRISSSECONDLETTER', new FilterOperator(FilterOperator::EQUAL), $query->getAcrissSecondLetter()),
            new Filter('ACRISSTHIRDLETTER', new FilterOperator(FilterOperator::EQUAL), $query->getAcrissThirdLetter()),
        ]));
        $response = $this->acrissRepository->getAcrissToAssociate($criteria);

        return new CheckIfAcrissHasChildsResponse($response->getCollection()->count() > 0);
    }
}
