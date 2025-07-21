<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Application\FilterAcrissBranch;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepositoryInterface;

class FilterAcrissBranchQueryHandler
{
    /**
     * @var AcrissBranchTranslationsRepositoryInterface
     */
    private AcrissBranchTranslationsRepositoryInterface $acrissBranchTranslationsRepository;

    public function __construct(AcrissBranchTranslationsRepositoryInterface $acrissBranchTranslationsRepository)
    {
        $this->acrissBranchTranslationsRepository = $acrissBranchTranslationsRepository;
    }

    /**
     * @param FilterAcrissBranchQuery $command
     * @return FilterAcrissBranchResponse
     */
    public function handle(FilterAcrissBranchQuery $command): FilterAcrissBranchResponse
    {
        $getByResponse = $this->acrissBranchTranslationsRepository->getBy(
            new AcrissBranchTranslationsCriteria(
                new FilterCollection(
                    [
                        new Filter('ACRISSID', new FilterOperator(FilterOperator::EQUAL), $command->getAcrissId())
                    ]
                )
            )
        );

        $response = [];

        if ($getByResponse->getCollection()->count() > 0) {
            /**
             * @var AcrissBranchTranslation $translation
             */
            foreach ($getByResponse->getCollection() as $translation) {
                $response[] = [
                    'branchId' => $translation->getBranch()->getId(),
                    'branchIATA' => $translation->getBranch()->getBranchIATA(),
                    'isDefault' => $translation->isByDefault()
                ];
            }
        }

        return new FilterAcrissBranchResponse($response);
    }
}
