<?php

namespace Distribution\Acriss\Application\CheckIfAcrissExists;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;

class CheckIfAcrissExistsQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private $acrissRepository;

    /**
     * CheckIfAcrissExistsQueryHandler constructor.
     *
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }

    /**
     * @param CheckIfAcrissExistsQuery $query
     * @return CheckIfAcrissExistsResponse
     */
    public function handle(CheckIfAcrissExistsQuery $query): CheckIfAcrissExistsResponse
    {
        $criteria = new AcrissCriteria(new FilterCollection([new Filter('ACRISSCODE', new FilterOperator(FilterOperator::EQUAL), $query->getAcriss())]));
        $response = $this->acrissRepository->getBy($criteria);

        return new CheckIfAcrissExistsResponse($response->getCollection()->count() > 0);
    }
}
