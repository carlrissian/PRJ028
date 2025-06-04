<?php

declare(strict_types=1);

namespace Distribution\StopSale\Domain;

use Shared\Domain\User;
use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\TimeValueObject;
use Shared\Domain\ValueObject\DateTimeValueObject;

class StopSale
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var Department|null
     */
    private ?Department $department;

    /**
     * @var StopSaleCategory
     */
    private StopSaleCategory $category;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $initDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $endDate;

    /**
     * @var AcrissCollection|null
     */
    private ?AcrissCollection $acriss;

    /**
     * @var RegionCollection|null
     */
    private ?RegionCollection $regionPickUp;

    /**
     * @var RegionCollection|null
     */
    private ?RegionCollection $regionDropOff;

    /**
     * @var AreaCollection|null
     */
    private ?AreaCollection $areaPickUp;

    /**
     * @var AreaCollection|null
     */
    private ?AreaCollection $areaDropOff;

    /**
     * @var BranchCollection|null
     */
    private ?BranchCollection $branchPickUp;

    /**
     * @var BranchCollection|null
     */
    private ?BranchCollection $branchDropOff;

    /**
     * @var PartnerCollection|null
     */
    private ?PartnerCollection $partners;

    /**
     * @var SellCodeCollection|null
     */
    private ?SellCodeCollection $sellCodes;

    /**
     * @var ProductCollection|null
     */
    private ?ProductCollection $products;

    /**
     * @var StopSaleType|null
     */
    private ?StopSaleType $stopSaleType;

    /**
     * @var TimeValueObject|null
     */
    private ?TimeValueObject $startTime;

    /**
     * @var TimeValueObject|null
     */
    private ?TimeValueObject $endTime;

    /**
     * @var DayCollection|null
     */
    private ?DayCollection $recurrence;

    /**
     * @var int|null
     */
    private ?int $minDaysRent;

    /**
     * @var int|null
     */
    private ?int $maxDaysRent;

    /**
     * @var bool|null
     */
    private ?bool $connectedVehicle;

    /**
     * @var string|null
     */
    private ?string $notes;

    /**
     * @var bool|null
     */
    private ?bool $cancelled;

    /**
     * @var User|null
     */
    private ?User $cancellationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $cancellationDate;

    /**
     * @var User|null
     */
    private ?User $creationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;

    /**
     * @var User|null
     */
    private ?User $edtionUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $editionDate;

    /**
     * StopSale constructor.
     *
     * @param integer|null $id
     * @param Department|null $department
     * @param StopSaleCategory|null $category
     * @param DateValueObject|null $initDate
     * @param DateValueObject|null $endDate
     * @param AcrissCollection|null $acriss
     * @param RegionCollection|null $regionPickUp
     * @param RegionCollection|null $regionDropOff
     * @param AreaCollection|null $areaPickUp
     * @param AreaCollection|null $areaDropOff
     * @param BranchCollection|null $branchPickUp
     * @param BranchCollection|null $branchDropOff
     * @param PartnerCollection|null $partners
     * @param SellCodeCollection|null $sellCodes
     * @param ProductCollection|null $products
     * @param StopSaleType|null $stopSaleType
     * @param TimeValueObject|null $startTime
     * @param TimeValueObject|null $endTime
     * @param DayCollection|null $recurrence
     * @param integer|null $minDaysRent
     * @param integer|null $maxDaysRent
     * @param boolean|null $connectedVehicle
     * @param string|null $notes
     * @param boolean|null $cancelled
     * @param User|null $cancellationUser
     * @param DateTimeValueObject|null $cancellationDate
     * @param User|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     * @param User|null $edtionUser
     * @param DateTimeValueObject|null $editionDate
     */
    public function __construct(
        ?int $id,
        ?Department $department,
        ?StopSaleCategory $category,
        ?DateValueObject $initDate,
        ?DateValueObject $endDate,
        ?AcrissCollection $acriss,
        ?RegionCollection $regionPickUp,
        ?RegionCollection $regionDropOff,
        ?AreaCollection $areaPickUp,
        ?AreaCollection $areaDropOff,
        ?BranchCollection $branchPickUp,
        ?BranchCollection $branchDropOff,
        ?PartnerCollection $partners,
        ?SellCodeCollection $sellCodes,
        ?ProductCollection $products,
        ?StopSaleType $stopSaleType,
        ?TimeValueObject $startTime,
        ?TimeValueObject $endTime,
        ?DayCollection $recurrence,
        ?int $minDaysRent,
        ?int $maxDaysRent,
        ?bool $connectedVehicle,
        ?string $notes,
        ?bool $cancelled = null,
        ?User $cancellationUser = null,
        ?DateTimeValueObject $cancellationDate = null,
        ?User $creationUser = null,
        ?DateTimeValueObject $creationDate = null,
        ?User $edtionUser = null,
        ?DateTimeValueObject $editionDate = null
    ) {
        $this->id = $id;
        $this->department = $department;
        $this->category = $category;
        $this->initDate = $initDate;
        $this->endDate = $endDate;
        $this->acriss = $acriss;
        $this->regionPickUp = $regionPickUp;
        $this->regionDropOff = $regionDropOff;
        $this->areaPickUp = $areaPickUp;
        $this->areaDropOff = $areaDropOff;
        $this->branchPickUp = $branchPickUp;
        $this->branchDropOff = $branchDropOff;
        $this->stopSaleType = $stopSaleType;
        $this->partners = $partners;
        $this->sellCodes = $sellCodes;
        $this->products = $products;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->recurrence = $recurrence;
        $this->minDaysRent = $minDaysRent;
        $this->maxDaysRent = $maxDaysRent;
        $this->connectedVehicle = $connectedVehicle;
        $this->notes = $notes;
        $this->cancelled = $cancelled;
        $this->cancellationUser = $cancellationUser;
        $this->cancellationDate = $cancellationDate;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
        $this->edtionUser = $edtionUser;
        $this->editionDate = $editionDate;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     */
    public function setDepartment($department): void
    {
        $this->department = $department;
    }

    /**
     * @return StopSaleCategory
     */
    public function getCategory(): StopSaleCategory
    {
        return $this->category;
    }

    /**
     * @param StopSaleCategory $category
     */
    public function setCategory(StopSaleCategory $category): void
    {
        $this->category = $category;
    }

    /**
     * @return DateValueObject|null
     */
    public function getInitDate(): ?DateValueObject
    {
        return $this->initDate;
    }

    /**
     * @param DateValueObject|null $initDate
     */
    public function setInitDate($initDate): void
    {
        $this->initDate = $initDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getEndDate(): ?DateValueObject
    {
        return $this->endDate;
    }

    /**
     * @param DateValueObject|null $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return AcrissCollection|null
     */
    public function getAcriss(): ?AcrissCollection
    {
        return $this->acriss;
    }

    /**
     * @param AcrissCollection|null $acriss
     */
    public function setAcriss($acriss): void
    {
        $this->acriss = $acriss;
    }

    /**
     * @return RegionCollection|null
     */
    public function getRegionPickUp(): ?RegionCollection
    {
        return $this->regionPickUp;
    }

    /**
     * @param RegionCollection|null $regionPickUp
     */
    public function setRegionPickUp($regionPickUp): void
    {
        $this->regionPickUp = $regionPickUp;
    }

    /**
     * @return RegionCollection|null
     */
    public function getRegionDropOff(): ?RegionCollection
    {
        return $this->regionDropOff;
    }

    /**
     * @param RegionCollection|null $regionDropOff
     */
    public function setRegionDropOff($regionDropOff): void
    {
        $this->regionDropOff = $regionDropOff;
    }

    /**
     * @return AreaCollection|null
     */
    public function getAreaPickUp(): ?AreaCollection
    {
        return $this->areaPickUp;
    }

    /**
     * @param AreaCollection|null $areaPickUp
     */
    public function setAreaPickUp($areaPickUp): void
    {
        $this->areaPickUp = $areaPickUp;
    }

    /**
     * @return AreaCollection|null
     */
    public function getAreaDropOff(): ?AreaCollection
    {
        return $this->areaDropOff;
    }

    /**
     * @param AreaCollection|null $areaDropOff
     */
    public function setAreaDropOff($areaDropOff): void
    {
        $this->areaDropOff = $areaDropOff;
    }

    /**
     * @return BranchCollection|null
     */
    public function getBranchPickUp(): ?BranchCollection
    {
        return $this->branchPickUp;
    }

    /**
     * @param BranchCollection|null $branchPickUp
     */
    public function setBranchPickUp($branchPickUp): void
    {
        $this->branchPickUp = $branchPickUp;
    }

    /**
     * @return BranchCollection|null
     */
    public function getBranchDropOff(): ?BranchCollection
    {
        return $this->branchDropOff;
    }

    /**
     * @param BranchCollection|null $branchDropOff
     */
    public function setBranchDropOff($branchDropOff): void
    {
        $this->branchDropOff = $branchDropOff;
    }

    /**
     * @return PartnerCollection|null
     */
    public function getPartners(): ?PartnerCollection
    {
        return $this->partners;
    }

    /**
     * @param PartnerCollection|null $partners
     */
    public function setPartners($partners): void
    {
        $this->partners = $partners;
    }

    /**
     * @return SellCodeCollection|null
     */
    public function getSellCodes(): ?SellCodeCollection
    {
        return $this->sellCodes;
    }

    /**
     * @param SellCodeCollection|null $sellCodes
     */
    public function setSellCodes($sellCodes): void
    {
        $this->sellCodes = $sellCodes;
    }

    /**
     * @return ProductCollection|null
     */
    public function getProducts(): ?ProductCollection
    {
        return $this->products;
    }

    /**
     * @param ProductCollection|null $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    /**
     * @return StopSaleType|null
     */
    public function getStopSaleType(): ?StopSaleType
    {
        return $this->stopSaleType;
    }

    /**
     * @param StopSaleType|null $stopSaleType
     */
    public function setStopSaleType($stopSaleType): void
    {
        $this->stopSaleType = $stopSaleType;
    }

    /**
     * @return TimeValueObject|null
     */
    public function getStartTime(): ?TimeValueObject
    {
        return $this->startTime;
    }

    /**
     * @param TimeValueObject|null $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return TimeValueObject|null
     */
    public function getEndTime(): ?TimeValueObject
    {
        return $this->endTime;
    }

    /**
     * @param TimeValueObject|null $endTime
     */
    public function setEndTime($endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return DayCollection|null
     */
    public function getRecurrence(): ?DayCollection
    {
        return $this->recurrence;
    }

    /**
     * @param DayCollection|null $recurrence
     */
    public function setRecurrence($recurrence): void
    {
        $this->recurrence = $recurrence;
    }

    /**
     * @return int|null
     */
    public function getMinDaysRent(): ?int
    {
        return $this->minDaysRent;
    }

    /**
     * @param int|null $minDaysRent
     */
    public function setMinDaysRent($minDaysRent): void
    {
        $this->minDaysRent = $minDaysRent;
    }

    /**
     * @return int|null
     */
    public function getMaxDaysRent(): ?int
    {
        return $this->maxDaysRent;
    }

    /**
     * @param int|null $maxDaysRent
     */
    public function setMaxDaysRent($maxDaysRent): void
    {
        $this->maxDaysRent = $maxDaysRent;
    }

    /**
     * @return bool|null
     */
    public function isConnectedVehicle(): ?bool
    {
        return $this->connectedVehicle;
    }

    /**
     * @param bool|null $connectedVehicle
     */
    public function setConnectedVehicle($connectedVehicle): void
    {
        $this->connectedVehicle = $connectedVehicle;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     */
    public function setNotes($notes): void
    {
        $this->notes = $notes;
    }

    /**
     * @return bool|null
     */
    public function isCancelled(): ?bool
    {
        return $this->cancelled;
    }

    /**
     * Set the value of cancelled always to true
     */
    public function setCancelled(): void
    {
        $this->cancelled = true;
    }

    /**
     * @return User|null
     */
    public function getCancellationUser(): ?User
    {
        return $this->cancellationUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCancellationDate(): ?DateTimeValueObject
    {
        return $this->cancellationDate;
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
     * @return User|null
     */
    public function getEdtionUser(): ?User
    {
        return $this->edtionUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getEditionDate(): ?DateTimeValueObject
    {
        return $this->editionDate;
    }


    /**
     * @param array|null $stopSaleArray
     * @return self
     */
    final public static function createFromArray(?array $stopSaleArray): self
    {
        $acrissCollection = new AcrissCollection([]);
        if (isset($stopSaleArray['AcrissArray'])) {
            foreach ($stopSaleArray['AcrissArray'] as $acrissArray) {
                $acrissCollection->add(Acriss::createFromArray($acrissArray));
            }
        }

        // TODO pendiente de crear carga para RegionPick, RegionDrop, AreaPick y AreaDrop
        $regionPickUpCollection = new RegionCollection([]);
        $regionDropOffCollection = new RegionCollection([]);
        $areaPickUpCollection = new AreaCollection([]);
        $areaDropOffCollection = new AreaCollection([]);

        $branchPickUpCollection = new BranchCollection([]);
        if (isset($stopSaleArray['pickUpBranchArray'])) {
            foreach ($stopSaleArray['pickUpBranchArray'] as $branchArray) {
                $branchPickUpCollection->add(Branch::createFromArray($branchArray));
            }
        }

        $branchDropOffCollection = new BranchCollection([]);
        if (isset($stopSaleArray['dropOffBranchArray'])) {
            foreach ($stopSaleArray['dropOffBranchArray'] as $branchArray) {
                $branchDropOffCollection->add(Branch::createFromArray($branchArray));
            }
        }

        $partnerCollection = new PartnerCollection([]);
        if (isset($stopSaleArray['partnerArray'])) {
            foreach ($stopSaleArray['partnerArray'] as $partnerArray) {
                $partnerCollection->add(Partner::createFromArray($partnerArray));
            }
        }

        $sellCodeCollection = new SellCodeCollection([]);
        if (isset($stopSaleArray['SellCodeArray'])) {
            foreach ($stopSaleArray['SellCodeArray'] as $sellCodeArray) {
                $sellCodeCollection->add(SellCode::createFromArray($sellCodeArray));
            }
        }

        $productCollection = new ProductCollection([]);
        if (isset($stopSaleArray['ProductArray'])) {
            foreach ($stopSaleArray['ProductArray'] as $productArray) {
                $productCollection->add(Product::createFromArray($productArray));
            }
        }

        $recurrenceCollection = new DayCollection([]);
        if (isset($stopSaleArray['Recurrence'])) {
            foreach ($stopSaleArray['Recurrence'] as $recurrenceArray) {
                $recurrenceCollection->add(Day::createFromArray($recurrenceArray));
            }
        }


        return new self(
            intval($stopSaleArray['ID']),
            (isset($stopSaleArray['department'])) ? Department::createFromArray($stopSaleArray['department']) : null,
            (isset($stopSaleArray['StopSalesCategory'])) ? StopSaleCategory::createFromArray($stopSaleArray['StopSalesCategory']) : null,
            (isset($stopSaleArray['INITDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['INITDATE'])) : null,
            (isset($stopSaleArray['ENDDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['ENDDATE'])) : null,
            $acrissCollection,
            $regionPickUpCollection,
            $regionDropOffCollection,
            $areaPickUpCollection,
            $areaDropOffCollection,
            $branchPickUpCollection,
            $branchDropOffCollection,
            $partnerCollection,
            $sellCodeCollection,
            $productCollection,
            (isset($stopSaleArray['StopSaleType'])) ? StopSaleType::createFromArray($stopSaleArray['StopSaleType']) : null,
            (isset($stopSaleArray['INITTIME'])) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($stopSaleArray['INITTIME'])) : null,
            (isset($stopSaleArray['ENDTIME'])) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($stopSaleArray['ENDTIME'])) : null,
            $recurrenceCollection,
            isset($stopSaleArray['MINDAYSRENT']) ? intval($stopSaleArray['MINDAYSRENT']) : null,
            isset($stopSaleArray['MAXDAYSRENT']) ? intval($stopSaleArray['MAXDAYSRENT']) : null,
            isset($stopSaleArray['CONNECTEDVEHICLE']) ? boolval($stopSaleArray['CONNECTEDVEHICLE']) : null,
            // filter_var($stopSaleArray['CONNECTEDVEHICLE'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            $stopSaleArray['DESCRIPTION'] ?? null,
            // isset($stopSaleArray['CANCEL']) ? boolval($stopSaleArray['CANCEL']) : null,
            filter_var($stopSaleArray['CANCEL'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            (isset($stopSaleArray['CancelationUser'])) ? User::createFromArray($stopSaleArray['CancelationUser']) : null,
            (isset($stopSaleArray['CANCELDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['CANCELDATE'])) : null,
            (isset($stopSaleArray['CREATIONUSER'])) ? User::createFromArray($stopSaleArray['CREATIONUSER']) : null,
            (isset($stopSaleArray['CREATIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['CREATIONDATE'])) : null,
            (isset($stopSaleArray['EDITIONUSER'])) ? User::createFromArray($stopSaleArray['EDITIONUSER']) : null,
            (isset($stopSaleArray['EDITIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['EDITIONDATE'])) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $acrissArray = [];
        if (!empty($this->getAcriss())) {
            /**
             * @var Acriss $acriss
             */
            foreach ($this->getAcriss() as $acriss) {
                $acrissArray[] = $acriss->toArray();
            }
        }

        $regionPickUpArray = [];
        if (!empty($this->getRegionPickUp())) {
            /**
             * @var Region $region
             */
            foreach ($this->getRegionPickUp() as $region) {
                $regionPickUpArray[] = $region->toArray();
            }
        }

        $regionDropOffArray = [];
        if (!empty($this->getRegionDropOff())) {
            /**
             * @var Region $region
             */
            foreach ($this->getRegionDropOff() as $region) {
                $regionDropOffArray[] = $region->toArray();
            }
        }

        $areaPickUpArray = [];
        if (!empty($this->getAreaPickUp())) {
            /**
             * @var Area $area
             */
            foreach ($this->getAreaPickUp() as $area) {
                $areaPickUpArray[] = $area->toArray();
            }
        }

        $areaDropOffArray = [];
        if (!empty($this->getAreaDropOff())) {
            /**
             * @var Area $area
             */
            foreach ($this->getAreaDropOff() as $area) {
                $areaDropOffArray[] = $area->toArray();
            }
        }

        $branchPickUpArray = [];
        if (!empty($this->getBranchPickUp())) {
            /**
             * @var Branch $branch
             */
            foreach ($this->getBranchPickUp() as $branch) {
                $branchPickUpArray[] = $branch->toArray();
            }
        }

        $branchDropOffArray = [];
        if (!empty($this->getBranchDropOff())) {
            /**
             * @var Branch $branch
             */
            foreach ($this->getBranchDropOff() as $branch) {
                $branchDropOffArray[] = $branch->toArray();
            }
        }

        $partnerArray = [];
        if (!empty($this->getPartners())) {
            /**
             * @var Partner $partner
             */
            foreach ($this->getPartners() as $partner) {
                $partnerArray[] = $partner->toArray();
            }
        }

        $sellCodeArray = [];
        if (!empty($this->getSellCodes())) {
            /**
             * @var SellCode $sellCode
             */
            foreach ($this->getSellCodes() as $sellCode) {
                $sellCodeArray[] = $sellCode->toArray();
            }
        }

        $productArray = [];
        if (!empty($this->getProducts())) {
            /**
             * @var Product $product
             */
            foreach ($this->getProducts() as $product) {
                $productArray[] = $product->toArray();
            }
        }

        $recurrenceArray = [];
        if (!empty($this->getRecurrence())) {
            /**
             * @var Day $day
             */
            foreach ($this->getRecurrence() as $day) {
                $recurrenceArray[] = $day->toArray();
            }
        }


        return [
            'ID' => $this->getId(),
            'DEPARTMENTID' => $this->getDepartment() ? $this->getDepartment()->getId() : null,
            'STOPSALECATID' => $this->getCategory()->getId(),
            'INITDATE' => $this->getInitDate() ? Utils::formatDateToFirstMinuteDateTime($this->getInitDate()->__toString()) : null,
            'ENDDATE' => $this->getEndDate() ? Utils::formatDateToLastMinuteDateTime($this->getEndDate()->__toString()) : null,
            'AcrissArray' => $acrissArray,
            'PickUpBranchIds' => $branchPickUpArray,
            'DropOffBranchIds' => $branchDropOffArray,
            'PartnerArray' => $partnerArray,
            'SellCodeArray' => $sellCodeArray,
            'ProductArray' => $productArray,
            'STOPSALETYPEID' => $this->getStopSaleType() ? $this->getStopSaleType()->getId() : null,
            'INITTIME' => $this->getStartTime() ? $this->getStartTime()->getTime() : null,
            'ENDTIME' => $this->getEndTime() ? $this->getEndTime()->getTime() : null,
            'Recurrence' => $recurrenceArray,
            'MINDAYSRENT' => $this->getMinDaysRent(),
            'MAXDAYSRENT' => $this->getMaxDaysRent(),
            'CONECTEDVEHICLE' => ($this->isConnectedVehicle() !== null) ? ($this->isConnectedVehicle() ? 1 : 0) : null,
            'DESCRIPTION' => $this->getNotes(),
            'CANCEL' => ($this->isCancelled() !== null) ? ($this->isCancelled() ? 1 : 0) : null,
        ];
    }
}
