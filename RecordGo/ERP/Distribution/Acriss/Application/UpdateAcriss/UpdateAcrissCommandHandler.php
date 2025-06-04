<?php

declare(strict_types=1);

namespace Distribution\Acriss\Application\UpdateAcriss;

use Shared\Domain\Criteria\Filter;
use Distribution\Acriss\Domain\GearBox;
use Distribution\Acriss\Domain\CarClass;
use Distribution\Acriss\Domain\AcrissType;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Acriss\Domain\MotorizationType;
use Distribution\Shared\Domain\RepositoryException;
use Distribution\AcrissBranchTranslations\Domain\Branch;
use Distribution\AcrissBranchTranslations\Domain\Language;
use Distribution\AcrissBranchTranslations\Domain\AcrissImageLine;
use Distribution\AcrissBranchTranslations\Domain\AcrissTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissImageLineCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissTranslationCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepository;

/**
 * Class UpdateAcrissCommandHandler
 * @package Distribution\Acriss\Application\UpdateAcriss
 */
class UpdateAcrissCommandHandler
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
     * @param UpdateAcrissCommand $command
     * @return UpdateAcrissResponse
     * @throws RepositoryException
     */
    final public function handle(UpdateAcrissCommand $command): UpdateAcrissResponse
    {
        $acriss = $this->acrissRepository->getById($command->getId());

        if ($command->getCarClassId() !== $acriss->getCarClass()->getId()) $acriss->setCarClass(new CarClass($command->getCarClassId()));
        if ($command->getAcrissTypeId() !== $acriss->getAcrissType()->getId()) $acriss->setAcrissType(new AcrissType($command->getAcrissTypeId()));
        if ($command->getGearBoxId() !== $acriss->getGearBox()->getId()) $acriss->setGearBox(new GearBox($command->getGearBoxId()));
        if ($command->getMotorizationTypeId() !== $acriss->getMotorizationType()->getId()) $acriss->setMotorizationType(new MotorizationType($command->getMotorizationTypeId()));
        // if ($command->getCarGroupId() !== $acriss->getCarGroup()->getId()) $acriss->setCarGroup(new CarGroup($command->getCarGroupId()));

        $acrissInferiorCollection = null;
        // TODO PARA V2 EDITAR ACRISS INFERIOR
        // if ($command->getAcriss4() === 'R') {
        //     $acrissInferiorCollection = new AcrissInferiorCollection([]);

        //     $filterCollection = new FilterCollection([new Filter('parentId', new FilterOperator(FilterOperator::EQUAL), $command->getAcrissId())]);
        //     $acrissChildCollection = $this->acrissRepository->getBy(new AcrissCriteria($filterCollection));


        //     // INTENTAR TRASLADAR LA LÓGICA DE LOS HIJOS A SCL
        //     //Modificar hijos no asociados a reserva, resto desvincular Acriss superior
        //     foreach ($acrissChildCollection->getCollection() as $acrissChild) {
        //         if (!$this->acrissRepository->checkIsOnBooking($acrissChild->getId())) {
        //             $editAcrissChild = new Acriss(
        //                 $acrissChild->getId(),
        //                 AcrissNameValueObject::create(
        //                     $command->getAcriss1(),
        //                     $command->getAcriss2(),
        //                     $command->getAcriss3(),
        //                     $acrissChild->getAcrissName()->getAcriss4()
        //                 ),
        //                 new CarClass($command->getCarClassId()),
        //                 new AcrissType($command->getAcrissId()),
        //                 new GearBox($command->getGearBoxId()),
        //                 new MotorizationType($acrissChild->getMotorizationType()->getId()),
        //                 $acrissChild->getCarGroup(),
        //                 $acrissChild()->getAcrissParentId(),
        //                 null,
        //                 $acrissChild->isEnabled()

        //             );
        //             $this->acrissRepository->update($editAcrissChild);
        //             $acrissInferiorCollection->add(new AcrissInferior($acrissChild->getId(), $acrissChild->getAcrissName()->__toString()));
        //         } else {
        //             $acrissChild->setAcrissParentId(null);
        //             $this->acrissRepository->update($acrissChild);
        //         }
        //     }
        // }
        if ($acrissInferiorCollection !== $acriss->getAcrissInferiorCollection()) $acriss->setAcrissInferiorCollection($acrissInferiorCollection);

        if ($command->getNumberOfSuitcases() !== $acriss->getNumberOfSuitcases()) $acriss->setNumberOfSuitcases($command->getNumberOfSuitcases());
        if ($command->getNumberOfSeats() !== $acriss->getNumberOfSeats()) $acriss->setNumberOfSeats($command->getNumberOfSeats());
        if ($command->getCommercialVehicle() !== $acriss->getCommercialVehicle()) $acriss->setCommercialVehicle($command->getCommercialVehicle());
        if ($command->getMediumTerm() !== $acriss->getMediumTerm()) $acriss->setMediumTerm($command->getMediumTerm());

        if ($command->getStartDate()) {
            $startDate = DateValueObject::createFromString($command->getStartDate());
            if ($startDate !== $acriss->getStartDate()) $acriss->setStartDate($startDate);
        } else {
            $acriss->setStartDate(null);
        }
        if ($command->getEndDate()) {
            $startDate = DateValueObject::createFromString($command->getEndDate());
            if ($startDate !== $acriss->getEndDate()) $acriss->setEndDate($startDate);
        } else {
            $acriss->setEndDate(null);
        }

        $acriss->setIsDriverLicenseClassB($command->hasDriverLicenseClassB());
        $acriss->setIsDriverLicenseClassA($command->hasDriverLicenseClassA());
        $acriss->setIsDriverLicenseClassA1($command->hasDriverLicenseClassA1());
        $acriss->setIsDriverLicenseClassA2($command->hasDriverLicenseClassA2());
        $acriss->setMinAgeExperienceDriverLicenseClassB($command->getMinAgeExperienceDriverLicenseClassB());
        $acriss->setMinAgeExperienceDriverLicenseClassA($command->getMinAgeExperienceDriverLicenseClassA());
        $acriss->setMinAgeExperienceDriverLicenseClassA1($command->getMinAgeExperienceDriverLicenseClassA1());
        $acriss->setMinAgeExperienceDriverLicenseClassA2($command->getMinAgeExperienceDriverLicenseClassA2());

        // TODO V2 (?)
        // if ($command->getMinAge() !== $acriss->getMinAge()) $acriss->setMinAge($command->getMinAge());
        // if ($command->getMaxAge() !== $acriss->getMaxAge()) $acriss->setMaxAge($command->getMaxAge());
        // if ($command->getFromHeight() !== $acriss->getFromHeight()) $acriss->setFromHeight($command->getFromHeight());
        // if ($command->getToHeight() !== $acriss->getToHeight()) $acriss->setToHeight($command->getToHeight());
        // if ($command->getFromLength() !== $acriss->getFromLength()) $acriss->setFromLength($command->getFromLength());
        // if ($command->getToLength() !== $acriss->getToLength()) $acriss->setToLength($command->getToLength());
        // if ($command->getFromWidth() !== $acriss->getFromWidth()) $acriss->setFromWidth($command->getFromWidth());
        // if ($command->getToWidth() !== $acriss->getToWidth()) $acriss->setToWidth($command->getToWidth());
        // if ($command->getFromTareWeight() !== $acriss->getFromTareWeight()) $acriss->setFromTareWeight($command->getFromTareWeight());
        // if ($command->getToTareWeight() !== $acriss->getToTareWeight()) $acriss->setToTareWeight($command->getToTareWeight());

        $updatedAcrissId = $this->acrissRepository->update($acriss);

        // TODO V1.2 de momento no se va a crear/actualizar desde frontend
        // if ($updatedAcrissId) {
        //     $acrissBranchTranslationsCollection = $this->acrissBranchTranslationsRepository->getBy(
        //         new AcrissBranchTranslationsCriteria(new FilterCollection([new Filter('ACRISSID', new FilterOperator(FilterOperator::EQUAL), $acriss->getId())]))
        //     )->getCollection();

        //     $branchTranslationsCollection = new AcrissBranchTranslationCollection([]);
        //     if ($command->getBranchTranslations() && count($command->getBranchTranslations()) > 0) {
        //         foreach ($command->getBranchTranslations() as $branchTranslation) {
        //             $imageLines = new AcrissImageLineCollection([]);
        //             if (isset($branchTranslation['imageLines']) && count($branchTranslation['imageLines']) > 0) {
        //                 foreach ($branchTranslation['imageLines'] as $imageLine) {
        //                     $imageLines->add(new AcrissImageLine(
        //                         isset($imageLine['id']) ? intval($imageLine['id']) : null,
        //                         $imageLine['url'],
        //                         $imageLine['name'],
        //                         filter_var($imageLine['byDefault'], FILTER_VALIDATE_BOOLEAN),
        //                     ));
        //                 }
        //             }

        //             $translations = new AcrissTranslationCollection([]);
        //             if (isset($branchTranslation['translations']) && count($branchTranslation['translations']) > 0) {
        //                 foreach ($branchTranslation['translations'] as $translation) {
        //                     $translations->add(new AcrissTranslation(
        //                         isset($translation['id']) ? intval($translation['id']) : null,
        //                         $translation['name'],
        //                         new Language(
        //                             intval($translation['language']['id']),
        //                             $translation['language']['name'],
        //                             $translation['language']['code']
        //                         ),
        //                         filter_var($translation['byDefault'], FILTER_VALIDATE_BOOLEAN),
        //                     ));
        //                 }
        //             }

        //             $branchTranslationsCollection->add(
        //                 new AcrissBranchTranslation(
        //                     isset($branchTranslation['id']) ? intval($branchTranslation['id']) : null,
        //                     new Branch($branchTranslation['branch']['id']),
        //                     filter_var($branchTranslation['byDefault'], FILTER_VALIDATE_BOOLEAN),
        //                     $translations,
        //                     $imageLines
        //                 )
        //             );
        //         }
        //     }

        //     if ($acrissBranchTranslationsCollection->count() > 0) {
        //     } else if ($branchTranslationsCollection->count() > 0) {
        //     }
        // }



        return new UpdateAcrissResponse(!!$updatedAcrissId, false);
    }
}
