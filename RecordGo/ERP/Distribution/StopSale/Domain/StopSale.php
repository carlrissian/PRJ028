<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\User as SharedUser;
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
    private ?RegionCollection $pickUpRegion;

    /**
     * @var AreaCollection|null
     */
    private ?AreaCollection $pickUpArea;

    /**
     * @var BranchCollection|null
     */
    private ?BranchCollection $pickUpBranch;

    /**
     * @var RegionCollection|null
     */
    private ?RegionCollection $dropOffRegion;

    /**
     * @var AreaCollection|null
     */
    private ?AreaCollection $dropOffArea;

    /**
     * @var BranchCollection|null
     */
    private ?BranchCollection $dropOffBranch;

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
     * @var SharedUser|null
     */
    private ?SharedUser $cancellationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $cancellationDate;

    /**
     * @var SharedUser|null
     */
    private ?SharedUser $creationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;

    /**
     * @var SharedUser|null
     */
    private ?SharedUser $editionUser;

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
     * @param RegionCollection|null $pickUpRegion
     * @param AreaCollection|null $pickUpArea
     * @param BranchCollection|null $pickUpBranch
     * @param RegionCollection|null $dropOffRegion
     * @param AreaCollection|null $dropOffArea
     * @param BranchCollection|null $dropOffBranch
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
     * @param SharedUser|null $cancellationUser
     * @param DateTimeValueObject|null $cancellationDate
     * @param SharedUser|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     * @param SharedUser|null $editionUser
     * @param DateTimeValueObject|null $editionDate
     */
    private function __construct(
        ?int $id,
        ?Department $department,
        ?StopSaleCategory $category,
        ?DateValueObject $initDate,
        ?DateValueObject $endDate,
        ?AcrissCollection $acriss,
        ?RegionCollection $pickUpRegion,
        ?AreaCollection $pickUpArea,
        ?BranchCollection $pickUpBranch,
        ?RegionCollection $dropOffRegion,
        ?AreaCollection $dropOffArea,
        ?BranchCollection $dropOffBranch,
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
        ?bool $cancelled,
        ?SharedUser $cancellationUser,
        ?DateTimeValueObject $cancellationDate,
        ?SharedUser $creationUser,
        ?DateTimeValueObject $creationDate,
        ?SharedUser $editionUser,
        ?DateTimeValueObject $editionDate
    ) {
        $this->id = $id;
        $this->department = $department;
        $this->category = $category;
        $this->initDate = $initDate;
        $this->endDate = $endDate;
        $this->acriss = $acriss;
        $this->pickUpRegion = $pickUpRegion;
        $this->pickUpArea = $pickUpArea;
        $this->pickUpBranch = $pickUpBranch;
        $this->dropOffRegion = $dropOffRegion;
        $this->dropOffArea = $dropOffArea;
        $this->dropOffBranch = $dropOffBranch;
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
        $this->editionUser = $editionUser;
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
     * @return StopSaleCategory
     */
    public function getCategory(): StopSaleCategory
    {
        return $this->category;
    }

    /**
     * @return DateValueObject|null
     */
    public function getInitDate(): ?DateValueObject
    {
        return $this->initDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getEndDate(): ?DateValueObject
    {
        return $this->endDate;
    }

    /**
     * @return AcrissCollection|null
     */
    public function getAcriss(): ?AcrissCollection
    {
        return $this->acriss;
    }

    /**
     * @return RegionCollection|null
     */
    public function getPickUpRegion(): ?RegionCollection
    {
        return $this->pickUpRegion;
    }

    /**
     * @return AreaCollection|null
     */
    public function getPickUpArea(): ?AreaCollection
    {
        return $this->pickUpArea;
    }

    /**
     * @return BranchCollection|null
     */
    public function getPickUpBranch(): ?BranchCollection
    {
        return $this->pickUpBranch;
    }

    /**
     * @return RegionCollection|null
     */
    public function getDropOffRegion(): ?RegionCollection
    {
        return $this->dropOffRegion;
    }

    /**
     * @return AreaCollection|null
     */
    public function getDropOffArea(): ?AreaCollection
    {
        return $this->dropOffArea;
    }

    /**
     * @return BranchCollection|null
     */
    public function getDropOffBranch(): ?BranchCollection
    {
        return $this->dropOffBranch;
    }

    /**
     * @return PartnerCollection|null
     */
    public function getPartners(): ?PartnerCollection
    {
        return $this->partners;
    }

    /**
     * @return SellCodeCollection|null
     */
    public function getSellCodes(): ?SellCodeCollection
    {
        return $this->sellCodes;
    }

    /**
     * @return ProductCollection|null
     */
    public function getProducts(): ?ProductCollection
    {
        return $this->products;
    }

    /**
     * @return StopSaleType|null
     */
    public function getStopSaleType(): ?StopSaleType
    {
        return $this->stopSaleType;
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
     * @return DayCollection|null
     */
    public function getRecurrence(): ?DayCollection
    {
        return $this->recurrence;
    }

    /**
     * @return int|null
     */
    public function getMinDaysRent(): ?int
    {
        return $this->minDaysRent;
    }

    /**
     * @return int|null
     */
    public function getMaxDaysRent(): ?int
    {
        return $this->maxDaysRent;
    }

    /**
     * @return bool|null
     */
    public function isConnectedVehicle(): ?bool
    {
        return $this->connectedVehicle;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @return bool|null
     */
    public function isCancelled(): ?bool
    {
        return $this->cancelled;
    }

    /**
     * @return SharedUser|null
     */
    public function getCancellationUser(): ?SharedUser
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
     * @return SharedUser|null
     */
    public function getEditionUser(): ?SharedUser
    {
        return $this->editionUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getEditionDate(): ?DateTimeValueObject
    {
        return $this->editionDate;
    }



    /**
     * @param integer|null $id
     * @param Department|null $department
     * @param StopSaleCategory|null $category
     * @param DateValueObject|null $initDate
     * @param DateValueObject|null $endDate
     * @param AcrissCollection|null $acriss
     * @param AreaCollection|null $pickUpRegion
     * @param AreaCollection|null $pickUpArea
     * @param BranchCollection|null $pickUpBranch
     * @param AreaCollection|null $dropOffRegion
     * @param AreaCollection|null $dropOffArea
     * @param BranchCollection|null $dropOffBranch
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
     * @param SharedUser|null $cancellationUser
     * @param DateTimeValueObject|null $cancellationDate
     * @param SharedUser|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     * @param SharedUser|null $editionUser
     * @param DateTimeValueObject|null $editionDate
     */
    public static function create(
        ?int $id,
        ?Department $department,
        ?StopSaleCategory $category,
        ?DateValueObject $initDate,
        ?DateValueObject $endDate,
        ?AcrissCollection $acriss,
        ?RegionCollection $pickUpRegion,
        ?AreaCollection $pickUpArea,
        ?BranchCollection $pickUpBranch,
        ?RegionCollection $dropOffRegion,
        ?AreaCollection $dropOffArea,
        ?BranchCollection $dropOffBranch,
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
        ?SharedUser $cancellationUser = null,
        ?DateTimeValueObject $cancellationDate = null,
        ?SharedUser $creationUser = null,
        ?DateTimeValueObject $creationDate = null,
        ?SharedUser $editionUser = null,
        ?DateTimeValueObject $editionDate = null
    ) {
        return new self(
            $id,
            $department,
            $category,
            $initDate,
            $endDate,
            $acriss,
            $pickUpRegion,
            $pickUpArea,
            $pickUpBranch,
            $dropOffRegion,
            $dropOffArea,
            $dropOffBranch,
            $partners,
            $sellCodes,
            $products,
            $stopSaleType,
            $startTime,
            $endTime,
            $recurrence,
            $minDaysRent,
            $maxDaysRent,
            $connectedVehicle,
            $notes,
            $cancelled,
            $cancellationUser,
            $cancellationDate,
            $creationUser,
            $creationDate,
            $editionUser,
            $editionDate
        );
    }

    /**
     * @param array|null $stopSaleArray
     * @return self
     */
    final public static function createFromArray(?array $stopSaleArray): self
    {
        return self::create(
            intval($stopSaleArray['ID']),
            (isset($stopSaleArray['department'])) ? Department::createFromArray($stopSaleArray['department']) : null,
            (isset($stopSaleArray['StopSalesCategory'])) ? StopSaleCategory::createFromArray($stopSaleArray['StopSalesCategory']) : null,
            (isset($stopSaleArray['INITDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['INITDATE'])) : null,
            (isset($stopSaleArray['ENDDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['ENDDATE'])) : null,
            isset($stopSaleArray['AcrissArray']) ? AcrissCollection::createFromArray($stopSaleArray['AcrissArray']) : null,
            isset($stopSaleArray['pickUpRegionArray']) ? RegionCollection::createFromArray($stopSaleArray['pickUpRegionArray']) : null,
            isset($stopSaleArray['pickUpAreaArray']) ? AreaCollection::createFromArray($stopSaleArray['pickUpAreaArray']) : null,
            isset($stopSaleArray['pickUpBranchArray']) ? BranchCollection::createFromArray($stopSaleArray['pickUpBranchArray']) : null,
            isset($stopSaleArray['dropOffRegionArray']) ? RegionCollection::createFromArray($stopSaleArray['dropOffRegionArray']) : null,
            isset($stopSaleArray['dropOffAreaArray']) ? AreaCollection::createFromArray($stopSaleArray['dropOffAreaArray']) : null,
            isset($stopSaleArray['dropOffBranchArray']) ? BranchCollection::createFromArray($stopSaleArray['dropOffBranchArray']) : null,
            isset($stopSaleArray['partnerArray']) ? PartnerCollection::createFromArray($stopSaleArray['partnerArray']) : null,
            isset($stopSaleArray['SellCodeArray']) ? SellCodeCollection::createFromArray($stopSaleArray['SellCodeArray']) : null,
            isset($stopSaleArray['ProductArray']) ? ProductCollection::createFromArray($stopSaleArray['ProductArray']) : null,
            (isset($stopSaleArray['StopSaleType'])) ? StopSaleType::createFromArray($stopSaleArray['StopSaleType']) : null,
            (isset($stopSaleArray['INITTIME'])) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($stopSaleArray['INITTIME'])) : null,
            (isset($stopSaleArray['ENDTIME'])) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($stopSaleArray['ENDTIME'])) : null,
            isset($stopSaleArray['Recurrence']) ? DayCollection::createFromArray($stopSaleArray['Recurrence']) : null,
            isset($stopSaleArray['MINDAYSRENT']) ? intval($stopSaleArray['MINDAYSRENT']) : null,
            isset($stopSaleArray['MAXDAYSRENT']) ? intval($stopSaleArray['MAXDAYSRENT']) : null,
            isset($stopSaleArray['CONNECTEDVEHICLE']) ? filter_var($stopSaleArray['CONNECTEDVEHICLE'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null,
            $stopSaleArray['DESCRIPTION'] ?? null,
            isset($stopSaleArray['CANCEL']) ? filter_var($stopSaleArray['CANCEL'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null,
            (isset($stopSaleArray['CancelationUser'])) ? SharedUser::createFromArray($stopSaleArray['CancelationUser']) : null,
            (isset($stopSaleArray['CANCELDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['CANCELDATE'])) : null,
            (isset($stopSaleArray['CREATIONUSER'])) ? SharedUser::createFromArray($stopSaleArray['CREATIONUSER']) : null,
            (isset($stopSaleArray['CREATIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['CREATIONDATE'])) : null,
            (isset($stopSaleArray['EDITIONUSER'])) ? SharedUser::createFromArray($stopSaleArray['EDITIONUSER']) : null,
            (isset($stopSaleArray['EDITIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($stopSaleArray['EDITIONDATE'])) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'DEPARTMENTID' => $this->getDepartment() ? $this->getDepartment()->getId() : null,
            'STOPSALECATID' => $this->getCategory()->getId(),
            'INITDATE' => $this->getInitDate() ? Utils::formatDateToFirstMinuteDateTime($this->getInitDate()->__toString()) : null,
            'ENDDATE' => $this->getEndDate() ? Utils::formatDateToLastMinuteDateTime($this->getEndDate()->__toString()) : null,
            'AcrissArray' => $this->getAcriss() ? $this->getAcriss()->toArraySAP() : null,
            'PickUpBranchIds' => $this->getPickUpBranch() ? $this->getPickUpBranch()->toArraySAP() : null,
            'DropOffBranchIds' => $this->getDropOffBranch() ? $this->getDropOffBranch()->toArraySAP() : null,
            'PartnerArray' => $this->getPartners() ? $this->getPartners()->toArraySAP() : null,
            'SellCodeArray' => $this->getSellCodes() ? $this->getSellCodes()->toArraySAP() : null,
            'ProductArray' => $this->getProducts() ? $this->getProducts()->toArraySAP() : null,
            'STOPSALETYPEID' => $this->getStopSaleType() ? $this->getStopSaleType()->getId() : null,
            'INITTIME' => $this->getStartTime() ? $this->getStartTime()->getTime() : null,
            'ENDTIME' => $this->getEndTime() ? $this->getEndTime()->getTime() : null,
            'Recurrence' => $this->getRecurrence() ? $this->getRecurrence()->toArraySAP() : null,
            'MINDAYSRENT' => $this->getMinDaysRent(),
            'MAXDAYSRENT' => $this->getMaxDaysRent(),
            'CONECTEDVEHICLE' => ($this->isConnectedVehicle() !== null) ? ($this->isConnectedVehicle() ? 1 : 0) : null,
            'DESCRIPTION' => $this->getNotes(),
            'CANCEL' => ($this->isCancelled() !== null) ? ($this->isCancelled() ? 1 : 0) : null,
        ];
    }
}
