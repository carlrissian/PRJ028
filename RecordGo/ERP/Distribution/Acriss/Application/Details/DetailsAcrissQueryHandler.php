<?php

namespace Distribution\Acriss\Application\Details;

use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepositoryInterface;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class DetailsAcrissQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @var AcrissBranchTranslationsRepositoryInterface
     */
    private AcrissBranchTranslationsRepositoryInterface $acrissBranchTranslationsRepository;

    /**
     * @param AcrissRepository $acrissRepository
     * @param AcrissBranchTranslationsRepositoryInterface $acrissBranchTranslationsRepository
     */
    public function __construct(
        AcrissRepository $acrissRepository,
        AcrissBranchTranslationsRepositoryInterface $acrissBranchTranslationsRepository
    ) {
        $this->acrissRepository = $acrissRepository;
        $this->acrissBranchTranslationsRepository = $acrissBranchTranslationsRepository;
    }

    public function handle(DetailsAcrissQuery $query): DetailsAcrissResponse
    {
        $acriss = $this->acrissRepository->getById($query->getId());

        $branchTranslationsGetByResponse = $this->acrissBranchTranslationsRepository->getBy(
            new AcrissBranchTranslationsCriteria(
                new FilterCollection(
                    [
                        new Filter('ACRISSID', new FilterOperator(FilterOperator::EQUAL), $acriss->getId())
                    ]
                )
            )
        );

        return new DetailsAcrissResponse($acriss, $branchTranslationsGetByResponse->getCollection()->toArray());
    }
}

