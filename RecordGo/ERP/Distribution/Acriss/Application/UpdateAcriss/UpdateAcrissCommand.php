<?php

declare(strict_types=1);

namespace Distribution\Acriss\Application\UpdateAcriss;

class UpdateAcrissCommand
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $carClassId;

    /**
     * @var int
     */
    private int $acrissTypeId;

    /**
     * @var int
     */
    private int $gearBoxId;

    /**
     * @var int
     */
    private int $motorizationTypeId;

    /**
     * @var string
     */
    private string $acrissCode;

    /**
     * @var string|null
     */
    private ?string $startDate;

    /**
     * @var string|null
     */
    private ?string $endDate;

    /**
     * @var bool|null
     */
    private ?bool $commercialVehicle;

    /**
     * @var bool|null
     */
    private ?bool $mediumTerm;

    /**
     * @var int|null
     */
    private ?int $numberOfSuitcases;

    /**
     * @var int|null
     */
    private ?int $vehicleSeatsId;

    /**
     * @var int|null
     */
    private ?int $numberOfDoors;

    /**
     * @var int|null
     */
    private ?int $minAge;

    /**
     * @var int|null
     */
    private ?int $maxAge;

    /**
     * @var bool|null
     */
    private ?bool $hasDriverLicenseClassB;

    /**
     * @var bool|null
     */
    private ?bool $hasDriverLicenseClassA;

    /**
     * @var bool|null
     */
    private ?bool $hasDriverLicenseClassA1;

    /**
     * @var bool|null
     */
    private ?bool $hasDriverLicenseClassA2;

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
     * @var array|null
     */
    private ?array $branchTranslations;

    /**
     * StoreAcrissCommand constructor.
     *
     * @param integer $id
     * @param integer $carClassId
     * @param integer $acrissTypeId
     * @param integer $gearBoxId
     * @param integer $motorizationTypeId
     * @param string $acrissCode
     * @param string|null $startDate
     * @param string|null $endDate
     * @param boolean|null $commercialVehicle
     * @param boolean|null $mediumTerm
     * @param integer|null $numberOfSuitcases
     * @param integer|null $vehicleSeatsId
     * @param integer|null $numberOfDoors
     * @param integer|null $minAge
     * @param integer|null $maxAge
     * @param boolean|null $hasDriverLicenseClassB
     * @param boolean|null $hasDriverLicenseClassA
     * @param boolean|null $hasDriverLicenseClassA1
     * @param boolean|null $hasDriverLicenseClassA2
     * @param integer|null $minAgeExperienceDriverLicenseClassB
     * @param integer|null $minAgeExperienceDriverLicenseClassA
     * @param integer|null $minAgeExperienceDriverLicenseClassA1
     * @param integer|null $minAgeExperienceDriverLicenseClassA2
     * @param array|null $branchTranslations
     */
    public function __construct(
        int $id,
        int $carClassId,
        int $acrissTypeId,
        int $gearBoxId,
        int $motorizationTypeId,
        string $acrissCode,
        ?string $startDate = null,
        ?string $endDate = null,
        ?bool $commercialVehicle = null,
        ?bool $mediumTerm = null,
        ?int $numberOfSuitcases = null,
        ?int $vehicleSeatsId = null,
        ?int $numberOfDoors = null,
        ?int $minAge = null,
        ?int $maxAge = null,
        ?bool $hasDriverLicenseClassB = null,
        ?bool $hasDriverLicenseClassA = null,
        ?bool $hasDriverLicenseClassA1 = null,
        ?bool $hasDriverLicenseClassA2 = null,
        ?int $minAgeExperienceDriverLicenseClassB = null,
        ?int $minAgeExperienceDriverLicenseClassA = null,
        ?int $minAgeExperienceDriverLicenseClassA1 = null,
        ?int $minAgeExperienceDriverLicenseClassA2 = null,
        ?array $branchTranslations = null
    ) {
        $this->id = $id;
        $this->carClassId = $carClassId;
        $this->acrissTypeId = $acrissTypeId;
        $this->gearBoxId = $gearBoxId;
        $this->motorizationTypeId = $motorizationTypeId;
        $this->acrissCode = $acrissCode;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->commercialVehicle = $commercialVehicle;
        $this->mediumTerm = $mediumTerm;
        $this->numberOfSuitcases = $numberOfSuitcases;
        $this->vehicleSeatsId = $vehicleSeatsId;
        $this->numberOfDoors = $numberOfDoors;
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
        $this->hasDriverLicenseClassB = $hasDriverLicenseClassB;
        $this->hasDriverLicenseClassA = $hasDriverLicenseClassA;
        $this->hasDriverLicenseClassA1 = $hasDriverLicenseClassA1;
        $this->hasDriverLicenseClassA2 = $hasDriverLicenseClassA2;
        $this->minAgeExperienceDriverLicenseClassB = $minAgeExperienceDriverLicenseClassB;
        $this->minAgeExperienceDriverLicenseClassA = $minAgeExperienceDriverLicenseClassA;
        $this->minAgeExperienceDriverLicenseClassA1 = $minAgeExperienceDriverLicenseClassA1;
        $this->minAgeExperienceDriverLicenseClassA2 = $minAgeExperienceDriverLicenseClassA2;
        $this->branchTranslations = $branchTranslations;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCarClassId(): int
    {
        return $this->carClassId;
    }

    /**
     * @return int
     */
    public function getAcrissTypeId(): int
    {
        return $this->acrissTypeId;
    }

    /**
     * @return int
     */
    public function getGearBoxId(): int
    {
        return $this->gearBoxId;
    }

    /**
     * @return int
     */
    public function getMotorizationTypeId(): int
    {
        return $this->motorizationTypeId;
    }

    /**
     * @return string
     */
    public function getAcrissCode(): string
    {
        return $this->acrissCode;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @return bool|null
     */
    public function getCommercialVehicle(): ?bool
    {
        return $this->commercialVehicle;
    }

    /**
     * @return bool|null
     */
    public function getMediumTerm(): ?bool
    {
        return $this->mediumTerm;
    }

    /**
     * @return int|null
     */
    public function getNumberOfSuitcases(): ?int
    {
        return $this->numberOfSuitcases;
    }

    /**
     * @return int|null
     */
    public function getVehicleSeatsId(): ?int
    {
        return $this->vehicleSeatsId;
    }

    /**
     * @return int|null
     */
    public function getNumberOfDoors(): ?int
    {
        return $this->numberOfDoors;
    }

    /**
     * @return int|null
     */
    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    /**
     * @return int|null
     */
    public function getMaxAge(): ?int
    {
        return $this->maxAge;
    }

    /**
     * @return bool|null
     */
    public function hasDriverLicenseClassB(): ?bool
    {
        return $this->hasDriverLicenseClassB;
    }

    /**
     * @return bool|null
     */
    public function hasDriverLicenseClassA(): ?bool
    {
        return $this->hasDriverLicenseClassA;
    }

    /**
     * @return bool|null
     */
    public function hasDriverLicenseClassA1(): ?bool
    {
        return $this->hasDriverLicenseClassA1;
    }

    /**
     * @return bool|null
     */
    public function hasDriverLicenseClassA2(): ?bool
    {
        return $this->hasDriverLicenseClassA2;
    }

    /**
     * @return int|null
     */
    public function getMinAgeExperienceDriverLicenseClassB(): ?int
    {
        return $this->minAgeExperienceDriverLicenseClassB;
    }

    /**
     * @return int|null
     */
    public function getMinAgeExperienceDriverLicenseClassA(): ?int
    {
        return $this->minAgeExperienceDriverLicenseClassA;
    }

    /**
     * @return int|null
     */
    public function getMinAgeExperienceDriverLicenseClassA1(): ?int
    {
        return $this->minAgeExperienceDriverLicenseClassA1;
    }

    /**
     * @return int|null
     */
    public function getMinAgeExperienceDriverLicenseClassA2(): ?int
    {
        return $this->minAgeExperienceDriverLicenseClassA2;
    }

    /**
     * @return array|null
     */
    public function getBranchTranslations(): ?array
    {
        return $this->branchTranslations;
    }
}
