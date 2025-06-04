<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Domain;

use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Shared\Domain\User;
use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\TimeValueObject;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\ParameterSettingType\Domain\ParameterSettingType;

class ParameterSetting
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var DateValueObject
     */
    private DateValueObject $startDate;

    /**
     * @var DateValueObject
     */
    private DateValueObject $endDate;

    /**
     * @var ParameterSettingType
     */
    private ParameterSettingType $type;

    /**
     * @var int
     */
    private int $parameter;

    /**
     * @var CarGroupCollection|null
     */
    private ?CarGroupCollection $carGroupCollection;

    /**
     * @var AcrissCollection
     */
    private AcrissCollection $acrissCollection;

    /**
     * @var AcrissCollection|null
     */
    private ?AcrissCollection $replacementAcrissCollection;

    /**
     * @var RegionCollection|null
     */
    private ?RegionCollection $regionCollection;

    /**
     * @var AreaCollection|null
     */
    private ?AreaCollection $areaCollection;

    /**
     * @var BranchCollection|null
     */
    private ?BranchCollection $branchCollection;

    /**
     * @var PartnerCollection
     */
    private PartnerCollection $partnerCollection;

    /**
     * @var TimeValueObject|null
     */
    private ?TimeValueObject $startTime;

    /**
     * @var TimeValueObject|null
     */
    private ?TimeValueObject $endTime;

    /**
     * @var bool
     */
    private bool $connectedVehicle;

    /**
     * @var bool
     */
    private bool $active;

    /**
     * @var User|null
     */
    private ?User $creationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;


    public function __construct(
        ?int $id,
        DateValueObject $startDate,
        DateValueObject $endDate,
        ParameterSettingType $type,
        int $parameter,
        ?CarGroupCollection $carGroupCollection = null,
        AcrissCollection $acrissCollection,
        ?AcrissCollection $replacementAcrissCollection,
        ?RegionCollection $regionCollection,
        ?AreaCollection $areaCollection,
        ?BranchCollection $branchCollection,
        PartnerCollection $partnerCollection,
        ?TimeValueObject $startTime,
        ?TimeValueObject $endTime,
        bool $connectedVehicle,
        bool $active,
        ?User $creationUser = null,
        ?DateTimeValueObject $creationDate = null
    ) {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->type = $type;
        $this->parameter = $parameter;
        $this->carGroupCollection = $carGroupCollection;
        $this->acrissCollection = $acrissCollection;
        $this->replacementAcrissCollection = $replacementAcrissCollection;
        $this->regionCollection = $regionCollection;
        $this->areaCollection = $areaCollection;
        $this->branchCollection = $branchCollection;
        $this->partnerCollection = $partnerCollection;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->connectedVehicle = $connectedVehicle;
        $this->active = $active;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateValueObject
     */
    public function getStartDate(): DateValueObject
    {
        return $this->startDate;
    }

    /**
     * @return DateValueObject
     */
    public function getEndDate(): ?DateValueObject
    {
        return $this->endDate;
    }

    /**
     * @return ParameterSettingType
     */
    public function getType(): ParameterSettingType
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getParameter(): int
    {
        return $this->parameter;
    }

    /**
     * @return CarGroupCollection|null
     */
    public function getCarGroupCollection(): ?CarGroupCollection
    {
        return $this->carGroupCollection;
    }

    /**
     * @return AcrissCollection
     */
    public function getAcrissCollection(): AcrissCollection
    {
        return $this->acrissCollection;
    }

    /**
     * @return AcrissCollection|null
     */
    public function getReplacementAcrissCollection(): ?AcrissCollection
    {
        return $this->replacementAcrissCollection;
    }

    /**
     * @return RegionCollection|null
     */
    public function getRegionCollection(): ?RegionCollection
    {
        return $this->regionCollection;
    }

    /**
     * @return AreaCollection|null
     */
    public function getAreaCollection(): ?AreaCollection
    {
        return $this->areaCollection;
    }

    /**
     * @return BranchCollection|null
     */
    public function getBranchCollection(): ?BranchCollection
    {
        return $this->branchCollection;
    }

    /**
     * @return PartnerCollection
     */
    public function getPartnerCollection(): PartnerCollection
    {
        return $this->partnerCollection;
    }

    /**
     * @return TimeValueObject|null
     */
    public function getStartTime(): ?TimeValueObject
    {
        return $this->startTime;
    }

    /**
     * @return TimeValueObject|null
     */
    public function getEndTime(): ?TimeValueObject
    {
        return $this->endTime;
    }

    /**
     * @return bool
     */
    public function isConnectedVehicle(): bool
    {
        return $this->connectedVehicle;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return User|null
     */
    public function getCreationUser(): ?User
    {
        return $this->creationUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        $acrissArray = [];
        if (!empty($this->getAcrissCollection())) {
            /**
             * @var Acriss $acriss
             */
            foreach ($this->getAcrissCollection() as $acriss) {
                $acrissArray[] = $acriss->toArray();
            }
        }

        $replacementAcrissArray = [];
        if (!empty($this->getReplacementAcrissCollection())) {
            /**
             * @var Acriss $replacementAcriss
             */
            foreach ($this->getReplacementAcrissCollection() as $replacementAcriss) {
                $replacementAcrissArray[] = $replacementAcriss->toArray();
            }
        }

        $regionCollectionArray = [];
        if (!empty($this->getRegionCollection())) {
            /**
             * @var Region $regionCollection
             */
            foreach ($this->getRegionCollection() as $regionCollection) {
                $regionCollectionArray[] = $regionCollection->toArray();
            }
        }

        $areaCollectionArray = [];
        if (!empty($this->getAreaCollection())) {
            /**
             * @var Area $areaCollection
             */
            foreach ($this->getAreaCollection() as $areaCollection) {
                $areaCollectionArray[] = $areaCollection->toArray();
            }
        }

        $branchCollectionArray = [];
        if (!empty($this->getBranchCollection())) {
            /**
             * @var Branch $branchCollection
             */
            foreach ($this->getBranchCollection() as $branchCollection) {
                $branchCollectionArray[] = $branchCollection->toArray();
            }
        }

        $partnerArray = [];
        if (!empty($this->getPartnerCollection())) {
            /**
             * @var Partner $partner
             */
            foreach ($this->getPartnerCollection() as $partner) {
                $partnerArray[] = $partner->toArray();
            }
        }


        return [
            'ID' => $this->getId(),
            'INITDATE' => $this->getStartDate() ? Utils::formatDateToFirstMinuteDateTime($this->getStartDate()->__toString()) : null,
            'ENDDATE' => $this->getEndDate() ? Utils::formatDateToLastMinuteDateTime($this->getEndDate()->__toString()) : null,
            'TYPEID' => $this->getType()->getId(),
            'PARAMETERLIMIT' => $this->getParameter(),
            'ACRISSIDARRAY' => $acrissArray,
            'REPLACEMENTACRISSIDARRAY' => $replacementAcrissArray,
            'REGIONIDARRAY' => $regionCollectionArray,
            'AREAIDARRAY' => $areaCollectionArray,
            'BRANCHIDARRAY' => $branchCollectionArray,
            'PARTNERIDARRAY' => $partnerArray,
            'INITTIME' => $this->getStartTime() ? $this->getStartTime()->getTime() : null,
            'ENDTIME' => $this->getEndTime() ? $this->getEndTime()->getTime() : null,
            'CONNECTED' => ($this->isConnectedVehicle() !== null) ? ($this->isConnectedVehicle() ? 1 : 0) : null,
            'ACTIVE' => ($this->isActive() !== null) ? ($this->isActive() ? 1 : 0) : null,
            'COSTCENTERNAME' => ConstantsJsonFile::getValue('COSTCENTER_LOGISTICS')
        ];
    }
}
