<?php

namespace Distribution\ParameterSetting\Domain;

use Shared\Utils\Utils;
use Shared\Domain\User as SharedUser;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\TimeValueObject;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
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
     * @var SharedUser|null
     */
    private ?SharedUser $creationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;

    /**
     * ParameterSetting constructor.
     *
     * @param integer|null $id
     * @param DateValueObject $startDate
     * @param DateValueObject $endDate
     * @param ParameterSettingType $type
     * @param integer $parameter
     * @param CarGroupCollection|null $carGroupCollection
     * @param AcrissCollection $acrissCollection
     * @param AcrissCollection|null $replacementAcrissCollection
     * @param RegionCollection|null $regionCollection
     * @param AreaCollection|null $areaCollection
     * @param BranchCollection|null $branchCollection
     * @param PartnerCollection $partnerCollection
     * @param TimeValueObject|null $startTime
     * @param TimeValueObject|null $endTime
     * @param boolean $connectedVehicle
     * @param boolean $active
     * @param SharedUser|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     */
    private function __construct(
        ?int $id,
        DateValueObject $startDate,
        DateValueObject $endDate,
        ParameterSettingType $type,
        int $parameter,
        ?CarGroupCollection $carGroupCollection,
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
        ?SharedUser $creationUser,
        ?DateTimeValueObject $creationDate
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
     * @return SharedUser|null
     */
    public function getCreationUser(): ?SharedUser
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
     * @param integer|null $id
     * @param DateValueObject $startDate
     * @param DateValueObject $endDate
     * @param ParameterSettingType $type
     * @param integer $parameter
     * @param CarGroupCollection|null $carGroupCollection
     * @param AcrissCollection $acrissCollection
     * @param AcrissCollection|null $replacementAcrissCollection
     * @param RegionCollection|null $regionCollection
     * @param AreaCollection|null $areaCollection
     * @param BranchCollection|null $branchCollection
     * @param PartnerCollection $partnerCollection
     * @param TimeValueObject|null $startTime
     * @param TimeValueObject|null $endTime
     * @param boolean $connectedVehicle
     * @param boolean $active
     * @param SharedUser|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     */
    public static function create(
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
        ?SharedUser $creationUser = null,
        ?DateTimeValueObject $creationDate = null
    ): self {
        $parameterSetting = new self(
            $id,
            $startDate,
            $endDate,
            $type,
            $parameter,
            $carGroupCollection,
            $acrissCollection,
            $replacementAcrissCollection,
            $regionCollection,
            $areaCollection,
            $branchCollection,
            $partnerCollection,
            $startTime,
            $endTime,
            $connectedVehicle,
            $active,
            $creationUser,
            $creationDate
        );
        return $parameterSetting;
    }

    /**
     * @param array|null $parameterSettingArray
     * @return self
     */
    public static function createFromArray(?array $parameterSettingArray): self
    {
        $acrissCollection = new AcrissCollection([]);
        foreach ($parameterSettingArray['ACRISSARRAY'] as $acrissArray) {
            $acrissCollection->add(Acriss::create(intval($acrissArray['ID']), $acrissArray['ACRISSCODE'], $acrissArray['VEHICLEGROUPNAME']));
        }

        $replacementAcrissCollection = new AcrissCollection([]);
        foreach ($parameterSettingArray['REPLACEMENTACRISSARRAY'] as $acrissArray) {
            $replacementAcrissCollection->add(Acriss::create(intval($acrissArray['ID']), $acrissArray['ACRISSCODE'], $acrissArray['VEHICLEGROUPNAME']));
        }

        $regionCollection = new RegionCollection([]);
        foreach ($parameterSettingArray['REGIONARRAY'] as $region) {
            $regionCollection->add(Region::create(intval($region['ID']), $region['NAME']));
        }

        $areaCollection = new AreaCollection([]);
        foreach ($parameterSettingArray['AREAARRAY'] as $area) {
            $areaCollection->add(Area::create(intval($area['ID']), $area['AREANAME']));
        }

        $brancheCollection = new BranchCollection([]);
        foreach ($parameterSettingArray['BRANCHARRAY'] as $branch) {
            $brancheCollection->add(Branch::create(intval($branch['ID']), $branch['BRANCHINTNAME']));
        }

        $partnerCollection = new PartnerCollection([]);
        foreach ($parameterSettingArray['PARTNERARRAY'] as $partner) {
            $partnerCollection->add(Partner::create(intval($partner['ID']), $partner['NAMESOCIAL']));
        }


        return ParameterSetting::create(
            intval($parameterSettingArray['ID']),
            isset($parameterSettingArray['INITDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($parameterSettingArray['INITDATE'])) : null,
            isset($parameterSettingArray['ENDDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($parameterSettingArray['ENDDATE'])) : null,
            isset($parameterSettingArray['TYPE']) ?
                ParameterSettingType::create(
                    intval($parameterSettingArray['TYPE']['ID']),
                    $parameterSettingArray['TYPE']['NAME']
                ) : null,
            intval($parameterSettingArray['PARAMETERLIMIT']),
            null,
            $acrissCollection,
            $replacementAcrissCollection,
            $regionCollection,
            $areaCollection,
            $brancheCollection,
            $partnerCollection,
            isset($parameterSettingArray['INITTIME']) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($parameterSettingArray['INITTIME'])) : null,
            isset($parameterSettingArray['ENDTIME']) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($parameterSettingArray['ENDTIME'])) : null,
            isset($parameterSettingArray['CONNECTED']) ? boolval($parameterSettingArray['CONNECTED']) : null,
            isset($parameterSettingArray['ACTIVE']) ? boolval($parameterSettingArray['ACTIVE']) : null,
            isset($parameterSettingArray['CREATIONUSER']) ? SharedUser::createFromArray($parameterSettingArray['CREATIONUSER']) : null,
            isset($parameterSettingArray['CREATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($parameterSettingArray['CREATIONDATE'])) : null,
        );
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
