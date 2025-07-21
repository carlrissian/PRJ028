<?php

declare(strict_types=1);

namespace Distribution\Acriss\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;

/**
 * Class Acriss
 * @package Distribution\Acriss\Domain
 */
class Acriss
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var CarClass
     */
    private CarClass $carClass;

    /**
     * @var AcrissType
     */
    private AcrissType $acrissType;

    /**
     * @var GearBox
     */
    private GearBox $gearBox;

    /**
     * @var MotorizationType
     */
    private MotorizationType $motorizationType;

    /**
     * @var CarGroup|null
     */
    private ?CarGroup $carGroup;

    /**
     * @var int|null
     */
    private ?int $acrissParentId;

    /**
     * @var AcrissInferiorCollection|null
     */
    private ?AcrissInferiorCollection $acrissInferiorCollection;

    /**
     * @var bool|null
     */
    private ?bool $enabled;

    /**
     * @var int|null
     */
    private ?int $numberOfSuitcases;

    /**
     * @var VehicleSeats|null
     */
    private ?VehicleSeats $vehicleSeats;

    /**
     * @var int|null
     */
    private ?int $numberOfDoors;

    /**
     * @var bool|null
     */
    private ?bool $commercialVehicle;

    /**
     * @var bool|null
     */
    private ?bool $mediumTerm;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $startDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $endDate;

    /**
     * @var bool|null
     */
    private ?bool $isDriverLicenseClassB;

    /**
     * @var bool|null
     */
    private ?bool $isDriverLicenseClassA;

    /**
     * @var bool|null
     */
    private ?bool $isDriverLicenseClassA1;

    /**
     * @var bool|null
     */
    private ?bool $isDriverLicenseClassA2;

    /**
     * @var int|null
     */
    private ?int $minAgeExperienceDriverLicenseClassB;

    /**
     * @var int|null
     */
    private ?int $minAgeExperienceDriverLicenseClassA;

    /**
     * @var int|null
     */
    private ?int $minAgeExperienceDriverLicenseClassA1;

    /**
     * @var int|null
     */
    private ?int $minAgeExperienceDriverLicenseClassA2;

    /**
     * @var int|null
     */
    private ?int $minAge;

    /**
     * @var int|null
     */
    private ?int $maxAge;

    /**
     * @var int|null
     */
    private ?int $fromHeight;

    /**
     * @var int|null
     */
    private ?int $toHeight;

    /**
     * @var int|null
     */
    private ?int $fromLength;

    /**
     * @var int|null
     */
    private ?int $toLength;

    /**
     * @var int|null
     */
    private ?int $fromWidth;

    /**
     * @var int|null
     */
    private ?int $toWidth;

    /**
     * @var int|null
     */
    private ?int $fromTareWeight;

    /**
     * @var int|null
     */
    private ?int $toTareWeight;

    // TODO FALTAN CAMPOS PARA FUNCIÓN REPOSITORIO GETBYID Y SHOWACRISS

    /**
     * Acriss constructor.
     * 
     * @param int|null $id
     * @param string|null $name
     * @param CarClass $carClass
     * @param AcrissType $acrissType
     * @param GearBox $gearBox
     * @param MotorizationType|null $motorizationType
     * @param CarGroup|null $carGroup
     * @param int|null $acrissParentId
     * @param AcrissInferiorCollection|null $acrissInferiorCollection
     * @param bool $enabled
     * @param int|null $numberOfSuitcases
     * @param VehicleSeats|null $vehicleSeats
     * @param int|null $numberOfDoors
     * @param bool|null $commercialVehicle
     * @param bool|null $mediumTerm
     * @param DateValueObject|null $startDate
     * @param DateValueObject|null $endDate
     * @param bool|null $isDriverLicenseClassB
     * @param bool|null $isDriverLicenseClassA
     * @param bool|null $isDriverLicenseClassA1
     * @param bool|null $isDriverLicenseClassA2
     * @param int|null $minAgeExperienceDriverLicenseClassB
     * @param int|null $minAgeExperienceDriverLicenseClassA
     * @param int|null $minAgeExperienceDriverLicenseClassA1
     * @param int|null $minAgeExperienceDriverLicenseClassA2
     * @param int|null $minAge
     * @param int|null $maxAge
     * @param int|null $fromHeight
     * @param int|null $toHeight
     * @param int|null $fromLength
     * @param int|null $toLength
     * @param int|null $fromWidth
     * @param int|null $toWidth
     * @param int|null $fromTareWeight
     * @param int|null $toTareWeight
     */
    private function __construct(
        ?int $id,
        ?string $name,
        CarClass $carClass,
        AcrissType $acrissType,
        GearBox $gearBox,
        MotorizationType $motorizationType,
        ?CarGroup $carGroup,
        ?int $acrissParentId,
        ?AcrissInferiorCollection $acrissInferiorCollection,
        ?bool $enabled,
        ?int $numberOfSuitcases,
        ?VehicleSeats $vehicleSeats,
        ?int $numberOfDoors,
        ?bool $commercialVehicle,
        ?bool $mediumTerm,
        ?DateValueObject $startDate,
        ?DateValueObject $endDate,
        ?bool $isDriverLicenseClassB,
        ?bool $isDriverLicenseClassA,
        ?bool $isDriverLicenseClassA1,
        ?bool $isDriverLicenseClassA2,
        ?int $minAgeExperienceDriverLicenseClassB,
        ?int $minAgeExperienceDriverLicenseClassA,
        ?int $minAgeExperienceDriverLicenseClassA1,
        ?int $minAgeExperienceDriverLicenseClassA2,
        ?int $minAge,
        ?int $maxAge,
        ?int $fromHeight,
        ?int $toHeight,
        ?int $fromLength,
        ?int $toLength,
        ?int $fromWidth,
        ?int $toWidth,
        ?int $fromTareWeight,
        ?int $toTareWeight
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->carClass = $carClass;
        $this->acrissType = $acrissType;
        $this->gearBox = $gearBox;
        $this->motorizationType = $motorizationType;
        $this->carGroup = $carGroup;
        $this->acrissParentId = $acrissParentId;
        $this->acrissInferiorCollection = $acrissInferiorCollection;
        $this->enabled = $enabled;
        $this->numberOfSuitcases = $numberOfSuitcases;
        $this->vehicleSeats = $vehicleSeats;
        $this->numberOfDoors = $numberOfDoors;
        $this->commercialVehicle = $commercialVehicle;
        $this->mediumTerm = $mediumTerm;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->isDriverLicenseClassB = $isDriverLicenseClassB;
        $this->isDriverLicenseClassA = $isDriverLicenseClassA;
        $this->isDriverLicenseClassA1 = $isDriverLicenseClassA1;
        $this->isDriverLicenseClassA2 = $isDriverLicenseClassA2;
        $this->minAgeExperienceDriverLicenseClassB = $minAgeExperienceDriverLicenseClassB;
        $this->minAgeExperienceDriverLicenseClassA = $minAgeExperienceDriverLicenseClassA;
        $this->minAgeExperienceDriverLicenseClassA1 = $minAgeExperienceDriverLicenseClassA1;
        $this->minAgeExperienceDriverLicenseClassA2 = $minAgeExperienceDriverLicenseClassA2;
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
        $this->fromHeight = $fromHeight;
        $this->toHeight = $toHeight;
        $this->fromLength = $fromLength;
        $this->toLength = $toLength;
        $this->fromWidth = $fromWidth;
        $this->toWidth = $toWidth;
        $this->fromTareWeight = $fromTareWeight;
        $this->toTareWeight = $toTareWeight;
    }

    /**
     * @return int|null
     */
    final public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return CarClass
     */
    final public function getCarClass(): CarClass
    {
        return $this->carClass;
    }

    /**
     * @return AcrissType
     */
    final public function getAcrissType(): AcrissType
    {
        return $this->acrissType;
    }

    /**
     * @return GearBox
     */
    final public function getGearBox(): GearBox
    {
        return $this->gearBox;
    }

    /**
     * @return MotorizationType
     */
    final public function getMotorizationType(): MotorizationType
    {
        return $this->motorizationType;
    }

    /**
     * @return CarGroup|null
     */
    final public function getCarGroup(): ?CarGroup
    {
        return $this->carGroup;
    }

    /**
     * @return int|null
     */
    final public function getAcrissParentId(): ?int
    {
        return $this->acrissParentId;
    }

    /**
     * @return AcrissInferiorCollection|null
     */
    final public function getAcrissInferiorCollection(): ?AcrissInferiorCollection
    {
        return $this->acrissInferiorCollection;
    }

    /**
     * @return bool
     */
    final public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @return int|null
     */
    final public function getNumberOfSuitcases(): ?int
    {
        return $this->numberOfSuitcases;
    }

    /**
     * @return VehicleSeats|null
     */
    final public function getVehicleSeats(): ?VehicleSeats
    {
        return $this->vehicleSeats;
    }

    /**
     * @return int|null
     */
    final public function getNumberOfDoors(): ?int
    {
        return $this->numberOfDoors;
    }

    /**
     * @return bool|null
     */
    final public function getCommercialVehicle(): ?bool
    {
        return $this->commercialVehicle;
    }

    /**
     * @return bool|null
     */
    final public function getMediumTerm(): ?bool
    {
        return $this->mediumTerm;
    }

    /**
     * @return DateValueObject|null
     */
    final public function getStartDate(): ?DateValueObject
    {
        return $this->startDate;
    }

    /**
     * @return DateValueObject|null
     */
    final public function getEndDate(): ?DateValueObject
    {
        return $this->endDate;
    }

    /**
     * @return bool|null
     */
    final public function isDriverLicenseClassB(): ?bool
    {
        return $this->isDriverLicenseClassB;
    }

    /**
     * @return bool|null
     */
    final public function isDriverLicenseClassA(): ?bool
    {
        return $this->isDriverLicenseClassA;
    }

    /**
     * @return bool|null
     */
    final public function isDriverLicenseClassA1(): ?bool
    {
        return $this->isDriverLicenseClassA1;
    }

    /**
     * @return bool|null
     */
    final public function isDriverLicenseClassA2(): ?bool
    {
        return $this->isDriverLicenseClassA2;
    }

    /**
     * @return int|null
     */
    final public function getMinAgeExperienceDriverLicenseClassB(): ?int
    {
        return $this->minAgeExperienceDriverLicenseClassB;
    }

    /**
     * @return int|null
     */
    final public function getMinAgeExperienceDriverLicenseClassA(): ?int
    {
        return $this->minAgeExperienceDriverLicenseClassA;
    }

    /**
     * @return int|null
     */
    final public function getMinAgeExperienceDriverLicenseClassA1(): ?int
    {
        return $this->minAgeExperienceDriverLicenseClassA1;
    }

    /**
     * @return int|null
     */
    final public function getMinAgeExperienceDriverLicenseClassA2(): ?int
    {
        return $this->minAgeExperienceDriverLicenseClassA2;
    }

    /**
     * @return int|null
     */
    final public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    /**
     * @return int|null
     */
    final public function getMaxAge(): ?int
    {
        return $this->maxAge;
    }

    /**
     * @return int|null
     */
    final public function getFromHeight(): ?int
    {
        return $this->fromHeight;
    }

    /**
     * @return int|null
     */
    final public function getToHeight(): ?int
    {
        return $this->toHeight;
    }

    /**
     * @return int|null
     */
    final public function getFromLength(): ?int
    {
        return $this->fromLength;
    }

    /**
     * @return int|null
     */
    final public function getToLength(): ?int
    {
        return $this->toLength;
    }

    /**
     * @return int|null
     */
    final public function getFromWidth(): ?int
    {
        return $this->fromWidth;
    }

    /**
     * @return int|null
     */
    final public function getToWidth(): ?int
    {
        return $this->toWidth;
    }

    /**
     * @return int|null
     */
    final public function getFromTareWeight(): ?int
    {
        return $this->fromTareWeight;
    }

    /**
     * @return int|null
     */
    final public function getToTareWeight(): ?int
    {
        return $this->toTareWeight;
    }


    /**
     * @param int|null $id
     * @param string|null $name
     * @param CarClass $carClass
     * @param AcrissType $acrissType
     * @param GearBox $gearBox
     * @param MotorizationType|null $motorizationType
     * @param CarGroup|null $carGroup
     * @param int|null $acrissParentId
     * @param AcrissInferiorCollection|null $acrissInferiorCollection
     * @param bool $enabled
     * @param int|null $numberOfSuitcases
     * @param VehicleSeats|null $vehicleSeats
     * @param int|null $numberOfDoors
     * @param bool|null $commercialVehicle
     * @param bool|null $mediumTerm
     * @param DateValueObject|null $startDate
     * @param DateValueObject|null $endDate
     * @param bool|null $isDriverLicenseClassB
     * @param bool|null $isDriverLicenseClassA
     * @param bool|null $isDriverLicenseClassA1
     * @param bool|null $isDriverLicenseClassA2
     * @param int|null $minAgeExperienceDriverLicenseClassB
     * @param int|null $minAgeExperienceDriverLicenseClassA
     * @param int|null $minAgeExperienceDriverLicenseClassA1
     * @param int|null $minAgeExperienceDriverLicenseClassA2
     * @param int|null $minAge
     * @param int|null $maxAge
     * @param int|null $fromHeight
     * @param int|null $toHeight
     * @param int|null $fromLength
     * @param int|null $toLength
     * @param int|null $fromWidth
     * @param int|null $toWidth
     * @param int|null $fromTareWeight
     * @param int|null $toTareWeight
     */
    public static function create(
        ?int $id,
        ?string $name,
        CarClass $carClass,
        AcrissType $acrissType,
        GearBox $gearBox,
        MotorizationType $motorizationType,
        ?CarGroup $carGroup = null,
        ?int $acrissParentId = null,
        ?AcrissInferiorCollection $acrissInferiorCollection = null,
        ?bool $enabled = null,
        ?int $numberOfSuitcases = null,
        ?VehicleSeats $vehicleSeats = null,
        ?int $numberOfDoors = null,
        ?bool $commercialVehicle = null,
        ?bool $mediumTerm = null,
        ?DateValueObject $startDate = null,
        ?DateValueObject $endDate = null,
        ?bool $isDriverLicenseClassB = null,
        ?bool $isDriverLicenseClassA = null,
        ?bool $isDriverLicenseClassA1 = null,
        ?bool $isDriverLicenseClassA2 = null,
        ?int $minAgeExperienceDriverLicenseClassB = null,
        ?int $minAgeExperienceDriverLicenseClassA = null,
        ?int $minAgeExperienceDriverLicenseClassA1 = null,
        ?int $minAgeExperienceDriverLicenseClassA2 = null,
        ?int $minAge = null,
        ?int $maxAge = null,
        ?int $fromHeight = null,
        ?int $toHeight = null,
        ?int $fromLength = null,
        ?int $toLength = null,
        ?int $fromWidth = null,
        ?int $toWidth = null,
        ?int $fromTareWeight = null,
        ?int $toTareWeight = null
    ) {
        return new self(
            $id,
            $name,
            $carClass,
            $acrissType,
            $gearBox,
            $motorizationType,
            $carGroup,
            $acrissParentId,
            $acrissInferiorCollection,
            $enabled,
            $numberOfSuitcases,
            $vehicleSeats,
            $numberOfDoors,
            $commercialVehicle,
            $mediumTerm,
            $startDate,
            $endDate,
            $isDriverLicenseClassB,
            $isDriverLicenseClassA,
            $isDriverLicenseClassA1,
            $isDriverLicenseClassA2,
            $minAgeExperienceDriverLicenseClassB,
            $minAgeExperienceDriverLicenseClassA,
            $minAgeExperienceDriverLicenseClassA1,
            $minAgeExperienceDriverLicenseClassA2,
            $minAge,
            $maxAge,
            $fromHeight,
            $toHeight,
            $fromLength,
            $toLength,
            $fromWidth,
            $toWidth,
            $fromTareWeight,
            $toTareWeight
        );
    }

    /**
     * @param array|null $acrissArray
     * @return self
     */
    final public static function createFromArray(?array $acrissArray): self
    {
        return self::create(
            intval($acrissArray['ID']),
            $acrissArray['ACRISSCODE'] ?? null,
            (isset($acrissArray['CARCLASS'])) ? CarClass::createFromArray($acrissArray['CARCLASS']) : null,
            (isset($acrissArray['TYPE'])) ? AcrissType::createFromArray($acrissArray['TYPE']) : null,
            (isset($acrissArray['GEARBOX'])) ? GearBox::createFromArray($acrissArray['GEARBOX']) : null,
            (isset($acrissArray['ENGINE'])) ? MotorizationType::createFromArray($acrissArray['ENGINE']) : null,
            (isset($acrissArray['CarGroup']) || isset($acrissArray['CARGROUP'])) ? CarGroup::createFromArray($acrissArray['CarGroup'] ?? $acrissArray['CARGROUP']) : null,
            (isset($acrissArray['ACRISSPARENTID'])) ? intval($acrissArray['ACRISSPARENTID']) : null,
            // TODO AcrissInferiorCollection
            null,
            (isset($acrissArray['ACRISSSTATUS'])) ? boolval($acrissArray['ACRISSSTATUS']) : null,
            (isset($acrissArray['ACRISSSUITCASE'])) ? intval($acrissArray['ACRISSSUITCASE']) : null,
            (isset($acrissArray['VEHICLESEATS'])) ? VehicleSeats::createFromArray($acrissArray['VEHICLESEATS']) : null,
            (isset($acrissArray['ACRISSDOORS'])) ? intval($acrissArray['ACRISSDOORS']) : null,
            (isset($acrissArray['LOGISTICSVEHICLE'])) ? boolval($acrissArray['LOGISTICSVEHICLE']) : null,
            (isset($acrissArray['MEDIUMTERM'])) ? boolval($acrissArray['MEDIUMTERM']) : null,
            (isset($acrissArray['STARTDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($acrissArray['STARTDATE'])) : null,
            (isset($acrissArray['ENDDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($acrissArray['ENDDATE'])) : null,
            (isset($acrissArray['DLCLASSB'])) ? boolval($acrissArray['DLCLASSB']) : null,
            (isset($acrissArray['DLCLASSA'])) ? boolval($acrissArray['DLCLASSA']) : null,
            (isset($acrissArray['DLCLASSA1'])) ? boolval($acrissArray['DLCLASSA1']) : null,
            (isset($acrissArray['DLCLASSA2'])) ? boolval($acrissArray['DLCLASSA2']) : null,
            (isset($acrissArray['DLMINEXPCLASSB'])) ? intval($acrissArray['DLMINEXPCLASSB']) : null,
            (isset($acrissArray['DLMINEXPCLASSA'])) ? intval($acrissArray['DLMINEXPCLASSA']) : null,
            (isset($acrissArray['DLMINEXPCLASSA1'])) ? intval($acrissArray['DLMINEXPCLASSA1']) : null,
            (isset($acrissArray['DLMINEXPCLASSA2'])) ? intval($acrissArray['DLMINEXPCLASSA2']) : null,
            (isset($acrissArray['DRIVERMINAGE'])) ? intval($acrissArray['DRIVERMINAGE']) : null,
            (isset($acrissArray['DRIVERMAXAGE'])) ? intval($acrissArray['DRIVERMAXAGE']) : null,
            (isset($acrissArray['FROMHEIGHT'])) ? intval($acrissArray['FROMHEIGHT']) : null,
            (isset($acrissArray['TOHEIGHT'])) ? intval($acrissArray['TOHEIGHT']) : null,
            (isset($acrissArray['FROMLENGTH'])) ? intval($acrissArray['FROMLENGTH']) : null,
            (isset($acrissArray['TOLENGTH'])) ? intval($acrissArray['TOLENGTH']) : null,
            (isset($acrissArray['FROMWIDTH'])) ? intval($acrissArray['FROMWIDTH']) : null,
            (isset($acrissArray['TOWIDTH'])) ? intval($acrissArray['TOWIDTH']) : null,
            (isset($acrissArray['FROMTAREWEIGHT'])) ? intval($acrissArray['FROMTAREWEIGHT']) : null,
            (isset($acrissArray['TOTAREWEIGHT'])) ? intval($acrissArray['TOTAREWEIGHT']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'ACRISSCARCLASS' => $this->getCarClass()->getId(),
            'ACRISSTYPE' => $this->getAcrissType()->getId(),
            'ACRISSTRANS' => $this->getGearBox()->getId(),
            'ACRISSMOTOR' => $this->getMotorizationType()->getId(),
            'VEHICLEGROUPID' => ($this->getCarGroup()) ? $this->getCarGroup()->getId() : null,
            'ACRISSSTATUS' => ($this->isEnabled() !== null) ? ($this->isEnabled() ? 1 : 0) : null,
            'ACRISSSUITCASE' => $this->getNumberOfSuitcases(),
            'ACRISSSEATSID' => $this->getVehicleSeats() ? $this->getVehicleSeats()->getId() : null,
            'ACRISSDOORS' => $this->getNumberOfDoors(),
            'LOGISTICSVEHICLE' => ($this->getCommercialVehicle() !== null) ? ($this->getCommercialVehicle() ? 1 : 0) : null,
            'MEDIUMTERM' => ($this->getMediumTerm() !== null) ? ($this->getMediumTerm() ? 1 : 0) : null,
            'DLCLASSB' => ($this->isDriverLicenseClassB() !== null) ? ($this->isDriverLicenseClassB() ? 1 : 0) : null,
            'DLCLASSA' => ($this->isDriverLicenseClassA() !== null) ? ($this->isDriverLicenseClassA() ? 1 : 0) : null,
            'DLCLASSA1' => ($this->isDriverLicenseClassA1() !== null) ? ($this->isDriverLicenseClassA1() ? 1 : 0) : null,
            'DLCLASSA2' => ($this->isDriverLicenseClassA2() !== null) ? ($this->isDriverLicenseClassA2() ? 1 : 0) : null,
            'DLMINEXPCLASSB' => $this->getMinAgeExperienceDriverLicenseClassB(),
            'DLMINEXPCLASSA' => $this->getMinAgeExperienceDriverLicenseClassA(),
            'DLMINEXPCLASSA1' => $this->getMinAgeExperienceDriverLicenseClassA1(),
            'DLMINEXPCLASSA2' => $this->getMinAgeExperienceDriverLicenseClassA2(),
            'DRIVERMINAGE' => $this->getMinAge(),
            'DRIVERMAXAGE' => $this->getMaxAge(),
            'STARTDATE' => $this->getStartDate() ? Utils::formatStringDateTimeToOdataDate($this->getStartDate()->__toString()) : null,
            'ENDDATE' => $this->getEndDate() ? Utils::formatDateToLastMinuteDateTime($this->getEndDate()->__toString()) : null,
        ];
    }
}
