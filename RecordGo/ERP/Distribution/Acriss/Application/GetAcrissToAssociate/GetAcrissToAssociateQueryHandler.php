<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\GetAcrissToAssociate;


use Distribution\Acriss\Domain\AcrissCollection;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class GetAcrissToAssociateQueryHandler
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

    public function handle(GetAcrissToAssociateQuery $getAcrissToAssociateQuery): GetAcrissToAssociateResponse
    {
        //TODO V2 -> BUSCAR ACRISS PARA ASOCIAR
        return new GetAcrissToAssociateResponse(new AcrissCollection([]), 0);

        $acriss = $this->acrissRepository->getById($getAcrissToAssociateQuery->getAcrissId());

        $filterAssociate = new FilterCollection([]);
        $filterAssociate->add(new Filter('acrissFirstLetter', new FilterOperator(FilterOperator::EQUAL), $this->getAcrissLetter($acriss->getName(), 0)));
        $filterAssociate->add(new Filter('acrissSecondLetter', new FilterOperator(FilterOperator::EQUAL), $this->getAcrissLetter($acriss->getName(), 1)));
        $filterAssociate->add(new Filter('acrissThirdLetter', new FilterOperator(FilterOperator::EQUAL), $this->getAcrissLetter($acriss->getName(), 2)));

        $fourthLetterFilterOperator =  $this->getAcrissLetter($acriss->getName(), 3) == 'R' ? new FilterOperator(FilterOperator::NOT_EQUAL) : new FilterOperator(FilterOperator::EQUAL);
        $filterAssociate->add(new Filter('acrissFourthLetter', $fourthLetterFilterOperator, 'R'));

        $filterAssociate->add(new Filter('parentId', new FilterOperator(FilterOperator::NOT_EQUAL), $acriss->getId()));

        $acrissAssociateCriteria = new AcrissCriteria($filterAssociate);
        $response = $this->acrissRepository->getBy($acrissAssociateCriteria);


        return new GetAcrissToAssociateResponse($response->getCollection(), $response->getTotalRows());
    }

    private function getAcrissLetter(?string $name, int $letterPosition): string
    {
        return $name[$letterPosition];
    }
}