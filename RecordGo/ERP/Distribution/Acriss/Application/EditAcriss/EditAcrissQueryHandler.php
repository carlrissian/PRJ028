<?php

declare(strict_types=1);


namespace Distribution\Acriss\Application\EditAcriss;

use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepository;
use Distribution\AcrissImageLine\Domain\AcrissImageLineRepository;
use Distribution\AcrissTranslations\Domain\AcrissTranslationsRepository;
use Distribution\AcrissType\Domain\AcrissTypeCriteria;
use Distribution\AcrissType\Domain\AcrissTypeRepository;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\CarClass\Domain\CarClassCriteria;
use Distribution\CarClass\Domain\CarClassRepository;
use Distribution\GearBox\Domain\GearBoxCriteria;
use Distribution\GearBox\Domain\GearBoxRepository;
use Distribution\MotorizationType\Domain\MotorizationTypeCriteria;
use Distribution\MotorizationType\Domain\MotorizationTypeRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

/**
 * Class EditAcrissCommandHandler
 * @package Distribution\Acriss\Application\EditAcriss
 */
class EditAcrissQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @var CarClassRepository
     */
    private CarClassRepository $carClassRepository;

    /**
     * @var AcrissTypeRepository
     */
    private AcrissTypeRepository $acrissTypeRepository;

    /**
     * @var GearBoxRepository
     */
    private GearBoxRepository $gearBoxRepository;

    /**
     * @var MotorizationTypeRepository
     */
    private MotorizationTypeRepository $motorizationRepository;

    /**
     * @var AcrissBranchTranslationsRepository
     */
    private AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository;

    /**
     * @var BranchRepository
     */
    private BranchRepository $branchRepository;

    /**
     * @param AcrissRepository $acrissRepository
     * @param CarClassRepository $carClassRepository
     * @param AcrissTypeRepository $acrissTypeRepository
     * @param GearBoxRepository $gearBoxRepository
     * @param MotorizationTypeRepository $motorizationRepository
     * @param AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository
     * @param BranchRepository $branchRepository
     */
    public function __construct(AcrissRepository $acrissRepository, CarClassRepository $carClassRepository, AcrissTypeRepository $acrissTypeRepository, GearBoxRepository $gearBoxRepository, MotorizationTypeRepository $motorizationRepository, AcrissBranchTranslationsRepository $acrissBranchTranslationsRepository, AcrissTranslationsRepository $acrissTranslationsRepository, AcrissImageLineRepository $acrissImageLineRepository, BranchRepository $branchRepository)
    {
        $this->acrissRepository = $acrissRepository;
        $this->carClassRepository = $carClassRepository;
        $this->acrissTypeRepository = $acrissTypeRepository;
        $this->gearBoxRepository = $gearBoxRepository;
        $this->motorizationRepository = $motorizationRepository;
        $this->acrissBranchTranslationsRepository = $acrissBranchTranslationsRepository;
        $this->branchRepository = $branchRepository;
    }


    public function handle(EditAcrissQuery $query): EditAcrissResponse
    {
        $acrissId = $query->getAcrissId();

        $acriss = $this->acrissRepository->getById($acrissId);

        $acrissName = str_split($acriss->getName());
        $acrissList = [
            'id' => $acrissId,
            'firstLetter' => $acrissName[0],
            'secondLetter' => $acrissName[1],
            'thirdLetter' => $acrissName[2],
            'fourthLetter' => $acrissName[3],
            'carClass' => $acriss->getCarClass()->getId(),
            'type' => $acriss->getAcrissType()->getId(),
            'gearBox' => $acriss->getGearBox()->getId(),
            'motorization' => $acriss->getMotorizationType()->getId(),
            'suitcase' => $acriss->getNumberSuitcase(),
            'seats' => $acriss->getNumberSeats(),
            'doors' => $acriss->getNumberDoors(),
            'commercialVehicle' => $acriss->getCommercialVehicle(),
            'mediumTerm' => $acriss->getMediumTerm(),
            'startDate' => $acriss->getStartDate(),
            'endDate' => $acriss->getEndDate(),
            'driverLicenseClassB' => $acriss->getIsDriverLicenseClassB(),
            'driverLicenseClassA' => $acriss->getIsDriverLicenseClassA(),
            'driverLicenseClassA1' => $acriss->getIsDriverLicenseClassA1(),
            'driverLicenseClassA2' => $acriss->getIsDriverLicenseClassA2(),
            'minAgeExperienceClassB' => $acriss->getMinAgeExperienceDriverLicenseClassB(),
            'minAgeExperienceClassA' => $acriss->getMinAgeExperienceDriverLicenseClassA(),
            'minAgeExperienceClassA1' => $acriss->getMinAgeExperienceDriverLicenseClassA1(),
            'minAgeExperienceClassA2' => $acriss->getMinAgeExperienceDriverLicenseClassA2(),
            'minAge' => $acriss->getMinAge(),
            'maxAge' => $acriss->getMaxAge(),
        ];

        $branchTranslationsResponse = $this->acrissBranchTranslationsRepository->getBy(
            new AcrissBranchTranslationsCriteria(
                new FilterCollection(
                    [
                        new Filter('ACRISSID', new FilterOperator(FilterOperator::EQUAL), $acrissId)
                    ]
                )
            )
        );

        $branchTranslationsList = [];
        foreach ($branchTranslationsResponse->getCollection() as $branchTranslation) {
            $branchTranslationId = $branchTranslation->getId();
            $branchId = $branchTranslation->getBranch()->getId();

            $commercialName = $branchTranslation->getBranch()->getName();
            $branchIATA = $branchTranslation->getBranch()->getBranchIATA();
            $default = $branchTranslation->isByDefault();

            $imageLineContent = [];
            foreach ($branchTranslation->getAcrissImageLines() as $imageLine) {

//                if ($branchId == $imageLine->getBranch()->getId()) {
                $imageLineContent[] = [
                    'id' => $imageLine->getId(),
                    'branchId' => $imageLine->getBranch()->getId(),
                    'description' => $imageLine->getDescription(),
                    'url' => $imageLine->getUrl(),
                    'index' => $imageLine->getIndex()
                ];
//                }
            }

            $translationsContent = [];

            foreach ($branchTranslation->getAcrissTranslations() as $translation) {

//                if ($branchId == $translation->getBranchId()) {
                $translationsContent[] = [
                    'id' => $translation->getId(),
                    'branchId' => $branchId,
                    'translation' => $translation->getName(),
                    'default' => $translation->isByDefault(),
                    'languageId' => $translation->getLanguage()->getId(),
                    'languageCode' => $translation->getLanguage()->getIso(),
                ];
//                }
            }

            $branchTranslationsList[] = [
                'id' => $branchTranslationId,
                'branchId' => $branchId,
                'commercialName' => $commercialName,
                'branchIATA' => $branchIATA,
                'default' => $default,
                'imageLines' => $imageLineContent,
                'translations' => $translationsContent
            ];
        }

        $branchResponse = $this->branchRepository->getBy(new BranchCriteria());
        $branchList = [];
        foreach ($branchResponse->getCollection() as $branch) {
            $branchList[] = [
                'id' => $branch->getId(),
                'name' => $branch->getName(),
                'branchIATA' => $branch->getBranchIATA(),
                'commercialName' => $branch->getName()
            ];
        }
        // Selectores para editar Acriss
        $carClassCollecion = $this->carClassRepository->getBy(new CarClassCriteria())->getCollection();
        $carClassList = $this->generateAcrissSelect($carClassCollecion);

        $acrissTypeCollection = $this->acrissTypeRepository->getBy(new AcrissTypeCriteria())->getCollection();
        $acrissTypeList = $this->generateAcrissSelect($acrissTypeCollection);

        $gearBoxCollection = $this->gearBoxRepository->getBy(new GearBoxCriteria())->getCollection();
        $gearBoxList = $this->generateAcrissSelect($gearBoxCollection);

        $motorizationCollection = $this->motorizationRepository->getBy(new MotorizationTypeCriteria())->getCollection();
        $motorizationList = $this->generateAcrissSelect($motorizationCollection);
        // Fin selectores editar Acriss

        return new EditAcrissResponse($acrissList, $branchTranslationsList, $carClassList, $acrissTypeList, $gearBoxList, $motorizationList, $branchList);
    }

    private function generateAcrissSelect($collection)
    {
        foreach ($collection as $item) {
            $result[] = [
                'id' => $item->getId(),
                'acrissLetter' => $item->getAcrissLetter(),
                'name' => $item->getName()
            ];
        }
        return $result;
    }
}
