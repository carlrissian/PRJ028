<?php

declare(strict_types=1);

namespace Distribution\Acriss\Application\UpdateAcriss;

use Shared\Domain\Criteria\Filter;
use Distribution\Acriss\Domain\Acriss;
use Distribution\Acriss\Domain\GearBox;
use Distribution\Acriss\Domain\CarClass;
use Distribution\Acriss\Domain\AcrissType;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\Acriss\Domain\VehicleSeats;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Acriss\Domain\MotorizationType;
use Distribution\AcrissBranchTranslations\Domain\Branch;
use Distribution\AcrissBranchTranslations\Domain\Language;
use Distribution\Acriss\Domain\Exception\AcrissNotFoundException;
use Distribution\AcrissBranchTranslations\Domain\AcrissImageLine;
use Distribution\AcrissBranchTranslations\Domain\AcrissTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissImageLineCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissTranslationCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepositoryInterface;

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

    /**
     * @param UpdateAcrissCommand $command
     * @return UpdateAcrissResponse
     */
    final public function handle(UpdateAcrissCommand $command): UpdateAcrissResponse
    {
        $acriss = $this->acrissRepository->getById($command->getId());

        if (empty($acriss)) {
            throw new AcrissNotFoundException("No se encontró un ACRISS con el ID: {$command->getId()}");
        }

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
        // if ($acrissInferiorCollection !== $acriss->getAcrissInferiorCollection()) $acriss->setAcrissInferiorCollection($acrissInferiorCollection);


        $carClass = ($command->getCarClassId() !== $acriss->getCarClass()->getId()) ? new CarClass($command->getCarClassId()) : $acriss->getCarClass();
        $acrissType = ($command->getAcrissTypeId() !== $acriss->getAcrissType()->getId()) ? new AcrissType($command->getAcrissTypeId()) : $acriss->getAcrissType();
        $gearBox = ($command->getGearBoxId() !== $acriss->getGearBox()->getId()) ? new GearBox($command->getGearBoxId()) : $acriss->getGearBox();
        $motorizationType = ($command->getMotorizationTypeId() !== $acriss->getMotorizationType()->getId()) ? new MotorizationType($command->getMotorizationTypeId()) : $acriss->getMotorizationType();

        $vehicleSeats = $command->getVehicleSeatsId() ? new VehicleSeats($command->getVehicleSeatsId()) : null;

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

        $acrissToUpdate = Acriss::create(
            $acriss->getId(),
            $acriss->getName(),
            $carClass,
            $acrissType,
            $gearBox,
            $motorizationType,
            $acriss->getCarGroup(),
            $acriss->getAcrissParentId(),
            $acriss->getAcrissInferiorCollection(), // De momento no se va a actualizar hasta que se implemente la lógica de arriba
            $acriss->isEnabled(),
            $command->getNumberOfSuitcases(),
            $vehicleSeats,
            $command->getNumberOfDoors(),
            $command->getCommercialVehicle(),
            $command->getMediumTerm(),
            $command->getStartDate() ? DateValueObject::createFromString($command->getStartDate()) : null,
            $command->getEndDate() ? DateValueObject::createFromString($command->getEndDate()) : null,
            $command->hasDriverLicenseClassB(),
            $command->hasDriverLicenseClassA(),
            $command->hasDriverLicenseClassA1(),
            $command->hasDriverLicenseClassA2(),
            $command->getMinAgeExperienceDriverLicenseClassB(),
            $command->getMinAgeExperienceDriverLicenseClassA(),
            $command->getMinAgeExperienceDriverLicenseClassA1(),
            $command->getMinAgeExperienceDriverLicenseClassA2()
        );

        $updatedAcrissId = $this->acrissRepository->update($acrissToUpdate);

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
