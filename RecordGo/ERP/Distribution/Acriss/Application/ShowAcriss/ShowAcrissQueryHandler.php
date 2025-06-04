<?php

declare(strict_types=1);

namespace Distribution\Acriss\Application\ShowAcriss;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\AcrissBranchTranslations\Domain\AcrissImageLine;
use Distribution\AcrissBranchTranslations\Domain\AcrissTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepository;

/**
 * Class ShowAcrissCommandHandler
 * @package Distribution\Acriss\Application\ShowAcriss
 */
class ShowAcrissQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;
    /**
     * @var AcrissBranchTranslationsRepository
     */
    private AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository;

    /**
     * @param AcrissRepository $acrissRepository
     * @param AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository
     */
    public function __construct(
        AcrissRepository $acrissRepository,
        AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository
    ) {
        $this->acrissRepository = $acrissRepository;
        $this->acrissBranchTranslationsRepository = $acrissBranchTranslationsRepository;
    }

    /**
     * @param ShowAcrissQuery $query
     * @return ShowAcrissResponse
     */
    public function handle(ShowAcrissQuery $query): ShowAcrissResponse
    {
        $acrissId = $query->getId();
        $acriss = $this->acrissRepository->getById($acrissId);

        // Obtener listado de delegaciones y traducciones
        $acrissBranchTranslationsResponse = $this->acrissBranchTranslationsRepository->getBy(
            new AcrissBranchTranslationsCriteria(
                new FilterCollection(
                    [
                        new Filter('ACRISSID', new FilterOperator(FilterOperator::EQUAL), $acrissId)
                    ]
                )
            )
        );

        $acrissBranchTranslations = [];
        /**
         * @var AcrissBranchTranslation $translation
         */
        foreach ($acrissBranchTranslationsResponse->getCollection() as $translation) {
            $acrissTranslations = [];
            /**
             * @var AcrissTranslation $acrissTranslation
             */
            foreach ($translation->getAcrissTranslations() as $acrissTranslation) {
                $acrissTranslations[] = [
                    'id' => $acrissTranslation->getId(),
                    'translation' => $acrissTranslation->getName(),
                    'default' => $acrissTranslation->isByDefault(),
                    'language' => [
                        'id' => $acrissTranslation->getLanguage()->getId(),
                        'iso' => $acrissTranslation->getLanguage()->getCode(),
                        'name' => $acrissTranslation->getLanguage()->getName(),
                    ],
                ];
            }

            $acrissImageLines = [];
            /**
             * @var AcrissImageLine $imageLine
             */
            foreach ($translation->getAcrissImageLines() as $imageLine) {

                $acrissImageLines[] = [
                    'id' => $imageLine->getId(),
                    'description' => $imageLine->getDescription(),
                    'url' => $imageLine->getUrl(),
                    'default' => $imageLine->isByDefault(),
                ];
            }

            $acrissBranchTranslations[] = [
                'id' => $translation->getId(),
                'branch' => [
                    'id' => $translation->getBranch()->getId(),
                    'name' => $translation->getBranch()->getName(),
                    'IATA' => $translation->getBranch()->getBranchIATA(),
                ],
                'default' => $translation->isByDefault(),
                'translations' => $acrissTranslations,
                'imageLines' => $acrissImageLines,
            ];
        }


        $acrissName = str_split($acriss->getName());

        $acrissArray = [
            'id' => $acriss->getId(),
            'acrissName' => $acriss->getName(),
            'acriss1stLetter' => $acrissName[0] ?? null,
            'acriss2ndLetter' => $acrissName[1] ?? null,
            'acriss3rdLetter' => $acrissName[2] ?? null,
            'acriss4thLetter' => $acrissName[3] ?? null,
            'carClass' => $acriss->getCarClass()->getName(),
            'acrissType' => $acriss->getAcrissType()->getName(),
            'gearBox' => $acriss->getGearBox()->getName(),
            'motorizationType' => $acriss->getMotorizationType()->getName(),
            'numberSuitcase' => $acriss->getNumberOfSuitcases(),
            'numberDoors' => $acriss->getNumberOfDoors(),
            'numberSeats' => $acriss->getNumberOfSeats(),
            'commercialVehicle' => $acriss->getCommercialVehicle(),
            'mediumTerm' => $acriss->getMediumTerm(),
            'startDate' => $acriss->getStartDate() ? $acriss->getStartDate()->__toString() : null,
            'endDate' => $acriss->getEndDate() ? $acriss->getEndDate()->__toString() : null,
            'minAge' => $acriss->getMinAge(),
            'maxAge' => $acriss->getMaxAge(),
            'driverLicenseClassB' => $acriss->isDriverLicenseClassB(),
            'driverLicenseClassA' => $acriss->isDriverLicenseClassA(),
            'driverLicenseClassA1' => $acriss->isDriverLicenseClassA1(),
            'driverLicenseClassA2' => $acriss->isDriverLicenseClassA2(),
            'minAgeExperienceClassB' => $acriss->getMinAgeExperienceDriverLicenseClassB(),
            'minAgeExperienceClassA' => $acriss->getMinAgeExperienceDriverLicenseClassA(),
            'minAgeExperienceClassA1' => $acriss->getMinAgeExperienceDriverLicenseClassA1(),
            'minAgeExperienceClassA2' => $acriss->getMinAgeExperienceDriverLicenseClassA2(),
            'minHeight' => $acriss->getFromHeight(),
            'maxHeight' => $acriss->getToHeight(),
            'minLength' => $acriss->getFromLength(),
            'maxLength' => $acriss->getToLength(),
            'minWidth' => $acriss->getFromWidth(),
            'maxWidth' => $acriss->getToWidth(),
            'minTareWeight' => $acriss->getFromTareWeight(),
            'maxTareWeight' => $acriss->getToTareWeight(),
            'branchTranslations' => $acrissBranchTranslations,
            'status' => $acriss->isEnabled(),
        ];

        return new ShowAcrissResponse($acrissArray);
    }
}
