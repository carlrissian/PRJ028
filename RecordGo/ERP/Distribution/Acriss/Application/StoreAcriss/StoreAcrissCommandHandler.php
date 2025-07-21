<?php

declare(strict_types=1);

namespace Distribution\Acriss\Application\StoreAcriss;

use Shared\Domain\Criteria\Filter;
use Distribution\Acriss\Domain\Acriss;
use Distribution\Acriss\Domain\GearBox;
use Distribution\Acriss\Domain\CarClass;
use Distribution\Acriss\Domain\AcrissType;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\Acriss\Domain\VehicleSeats;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Acriss\Domain\AcrissCriteria;
use Shared\Domain\ValueObject\DateValueObject;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Acriss\Domain\AcrissException;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Acriss\Domain\MotorizationType;

/**
 * Class StoreAcrissCommandHandler
 * @package Distribution\Acriss\Application\StoreAcriss
 */
class StoreAcrissCommandHandler
{
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @param AcrissRepository $acrissRepository
     */
    public function __construct(AcrissRepository $acrissRepository)
    {
        $this->acrissRepository = $acrissRepository;
    }

    /**
     * @param StoreAcrissCommand $command
     * @return StoreAcrissResponse
     * @throws RepositoryException
     */
    final public function handle(StoreAcrissCommand $command): StoreAcrissResponse
    {
        $carClassId = $command->getCarClassId();
        $acrissTypeId = $command->getAcrissTypeId();
        $gearBoxId = $command->getGearBoxId();
        $motorizationId = $command->getMotorizationTypeId();

        $startDate = $command->getStartDate() ? DateValueObject::createFromString($command->getStartDate()) : null;
        $endDate = $command->getEndDate() ? DateValueObject::createFromString($command->getEndDate()) : null;
        $commercialVehicle = $command->getCommercialVehicle();
        $mediumTerm = $command->getMediumTerm();
        $numberSuitcase = $command->getNumberOfSuitcases();
        $vehicleSeatsId = $command->getVehicleSeatsId();
        $numberDoors = $command->getNumberOfDoors();

        $minAge = $command->getMinAge();
        $maxAge = $command->getMaxAge();
        $isDriverLicenseClassB = $command->hasDriverLicenseClassB();
        $isDriverLicenseClassA = $command->hasDriverLicenseClassA();
        $isDriverLicenseClassA1 = $command->hasDriverLicenseClassA1();
        $isDriverLicenseClassA2 = $command->hasDriverLicenseClassA2();
        $minAgeClassB = $command->getMinAgeExperienceDriverLicenseClassB();
        $minAgeClassA = $command->getMinAgeExperienceDriverLicenseClassA();
        $minAgeClassA1 = $command->getMinAgeExperienceDriverLicenseClassA1();
        $minAgeClassA2 = $command->getMinAgeExperienceDriverLicenseClassA2();


        $acrissExistResponse = $this->acrissRepository->getBy(new AcrissCriteria(
            new FilterCollection([new Filter('ACRISSCODE', new FilterOperator(FilterOperator::EQUAL), $command->getAcrissCode())])
        ));
        if ($acrissExistResponse->getTotalRows() > 0) {
            throw new AcrissException('ACRISS exists', Response::HTTP_BAD_REQUEST);
        }

        $acriss = Acriss::create(
            null,
            $command->getAcrissCode(),
            new CarClass($carClassId),
            new AcrissType($acrissTypeId),
            new GearBox($gearBoxId),
            new MotorizationType($motorizationId),
            null,
            null,
            null,
            true,
            $numberSuitcase,
            $vehicleSeatsId ? new VehicleSeats($vehicleSeatsId) : null,
            $numberDoors,
            $commercialVehicle,
            $mediumTerm,
            $startDate,
            $endDate,
            $isDriverLicenseClassB,
            $isDriverLicenseClassA,
            $isDriverLicenseClassA1,
            $isDriverLicenseClassA2,
            $minAgeClassB,
            $minAgeClassA,
            $minAgeClassA1,
            $minAgeClassA2,
            $minAge,
            $maxAge
        );

        $createdAcrissId = $this->acrissRepository->store($acriss);

        // para versión 2.0, si motorizationType es R, se debe crear un acriss con motorizationType = D y V
        //SI ACABA EN 'R' Y NO EXISTE CREAR 2 TIPOS DE ACRISS, ACABADO EN 'D' Y EN 'V'
        //        if( $motorization->getAcrissLetter() == 'R'){
        //
        //            $filterAssociate = new FilterCollection([]);
        //            $filterAssociate->add(new Filter('acrissFirstLetter', new FilterOperator(FilterOperator::EQUAL), $carClass->getAcrissLetter()));
        //            $filterAssociate->add(new Filter('acrissSecondLetter', new FilterOperator(FilterOperator::EQUAL), $acrissType->getAcrissLetter()));
        //            $filterAssociate->add(new Filter('acrissThirdLetter', new FilterOperator(FilterOperator::EQUAL), $gearBox->getAcrissLetter()));
        //            $filterAssociate->add(new Filter('acrissFourthLetter', new FilterOperator(FilterOperator::NOT_EQUAL), "R"));
        //
        //            $acrissAssociateCriteria = new AcrissCriteria($filterAssociate);
        //            $response = $this->acrissRepository->getBy($acrissAssociateCriteria);
        //
        //            if($response->getTotalRows()==0){
        //
        //                $acriss1 = new Acriss(
        //                    null,
        //                    AcrissNameValueObject::create(
        //                        $carClass->getAcrissLetter(),
        //                        $acrissType->getAcrissLetter(),
        //                        $gearBox->getAcrissLetter(),
        //                        "D"
        //                    ),
        //                    new CarClass($carClassId),
        //                    new AcrissType($acrissTypeId),
        //                    new GearBox($gearBoxId),
        //                    new MotorizationType($motorizationId),
        //                    null,
        //                    $acrissCreatedResponse->getId(),
        //                    null,
        //                    true,
        //                    $numberSuitcase,
        //                    $numberSeats,
        //                    $numberDoors,
        //                    $commercialVehicle,
        //                    $mediumTerm,
        //                    $startDate,
        //                    $endDate
        //                );
        //                $this->acrissRepository->store($acriss1);
        //
        //                $acriss2 = new Acriss(
        //                    null,
        //                    AcrissNameValueObject::create(
        //                        $carClass->getAcrissLetter(),
        //                        $acrissType->getAcrissLetter(),
        //                        $gearBox->getAcrissLetter(),
        //                        "V"
        //                    ),
        //                    new CarClass($carClassId),
        //                    new AcrissType($acrissTypeId),
        //                    new GearBox($gearBoxId),
        //                    new MotorizationType($motorizationId),
        //                    null,
        //                    $acrissCreatedResponse->getId(),
        //                    null,
        //                    true,
        //                    $numberSuitcase,
        //                    $numberSeats,
        //                    $numberDoors,
        //                    $commercialVehicle,
        //                    $mediumTerm,
        //                    $startDate,
        //                    $endDate
        //                );
        //                $this->acrissRepository->store($acriss2);
        //
        //                $message = "Se ha creado el Acriss ".$acrissCreatedResponse->getAcrissName()->__toString()." y los Acriss inferiores: ".$acriss1->getAcrissName()->__toString().' y '.$acriss2->getAcrissName()->__toString();
        //            }
        //        }
        //

        return new StoreAcrissResponse(!!$createdAcrissId, $createdAcrissId);
    }
}
