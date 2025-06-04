<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\UpdateStopSale;

class UpdateStopSaleCommand
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var int|null
     */
    private $departmentId;

    /**
     * @var string|null
     */
    private $initDate;

    /**
     * @var string|null
     */
    private $endDate;

    /**
     * @var array|null
     */
    private $acrissId;

    /**
     * @var array|null
     */
    private $regionPickUpId;

    /**
     * @var array|null
     */
    private $regionDropOffId;

    /**
     * @var array|null
     */
    private $areaPickUpId;

    /**
     * @var array|null
     */
    private $areaDropOffId;

    /**
     * @var array|null
     */
    private $branchPickUpId;

    /**
     * @var array|null
     */
    private $branchDropOffId;

    /**
     * @var array|null
     */
    private $partnersId;

    /**
     * @var array|null
     */
    private $sellCodesId;

    /**
     * @var array|null
     */
    private $productsId;

    /**
     * @var int|null
     */
    private $stopSaleTypeId;

    /**
     * @var string|null
     */
    private $startTime;

    /**
     * @var string|null
     */
    private $endTime;

    /**
     * @var array|null
     */
    private $recurrencesId;

    /**
     * @var int|null
     */
    private $minDaysRent;

    /**
     * @var int|null
     */
    private $maxDaysRent;

    /**
     * @var bool|null
     */
    private $connectedVehicle;

    /**
     * @var string|null
     */
    private $notes;

    /**
     * StoreStopSaleCommand constructor.
     *
     * @param integer $id
     * @param integer $categoryId
     * @param integer|null $departmentId
     * @param string|null $initDate
     * @param string|null $endDate
     * @param array|null $acrissId
     * @param array|null $regionPickUpId
     * @param array|null $regionDropOffId
     * @param array|null $areaPickUpId
     * @param array|null $areaDropOffId
     * @param array|null $branchPickUpId
     * @param array|null $branchDropOffId
     * @param array|null $partnersId
     * @param array|null $sellCodesId
     * @param array|null $productsId
     * @param integer|null $stopSaleTypeId
     * @param string|null $startTime
     * @param string|null $endTime
     * @param array|null $recurrencesId
     * @param integer|null $minDaysRent
     * @param integer|null $maxDaysRent
     * @param boolean|null $connectedVehicle
     * @param string|null $notes
     */
    public function __construct(
        int $id,
        int $categoryId,
        ?int $departmentId,
        ?string $initDate,
        ?string $endDate,
        ?array $acrissId,
        ?array $regionPickUpId,
        ?array $regionDropOffId,
        ?array $areaPickUpId,
        ?array $areaDropOffId,
        ?array $branchPickUpId,
        ?array $branchDropOffId,
        ?array $partnersId,
        ?array $sellCodesId,
        ?array $productsId,
        ?int $stopSaleTypeId,
        ?string $startTime,
        ?string $endTime,
        ?array $recurrencesId,
        ?int $minDaysRent,
        ?int $maxDaysRent,
        ?bool $connectedVehicle,
        ?string $notes
    ) {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->departmentId = $departmentId;
        $this->initDate = $initDate;
        $this->endDate = $endDate;
        $this->acrissId = $acrissId;
        $this->regionPickUpId = $regionPickUpId;
        $this->regionDropOffId = $regionDropOffId;
        $this->areaPickUpId = $areaPickUpId;
        $this->areaDropOffId = $areaDropOffId;
        $this->branchPickUpId = $branchPickUpId;
        $this->branchDropOffId = $branchDropOffId;
        $this->partnersId = $partnersId;
        $this->sellCodesId = $sellCodesId;
        $this->productsId = $productsId;
        $this->stopSaleTypeId = $stopSaleTypeId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->recurrencesId = $recurrencesId;
        $this->minDaysRent = $minDaysRent;
        $this->maxDaysRent = $maxDaysRent;
        $this->connectedVehicle = $connectedVehicle;
        $this->notes = $notes;
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
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * @return int|null
     */
    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    /**
     * @return string|null
     */
    public function getInitDate(): ?string
    {
        return $this->initDate;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @return array|null
     */
    public function getAcrissId(): ?array
    {
        return $this->acrissId;
    }

    /**
     * @return array|null
     */
    public function getRegionPickUpId(): ?array
    {
        return $this->regionPickUpId;
    }

    /**
     * @return array|null
     */
    public function getRegionDropOffId(): ?array
    {
        return $this->regionDropOffId;
    }

    /**
     * @return array|null
     */
    public function getAreaPickUpId(): ?array
    {
        return $this->areaPickUpId;
    }

    /**
     * @return array|null
     */
    public function getAreaDropOffId(): ?array
    {
        return $this->areaDropOffId;
    }

    /**
     * @return array|null
     */
    public function getBranchPickUpId(): ?array
    {
        return $this->branchPickUpId;
    }

    /**
     * @return array|null
     */
    public function getBranchDropOffId(): ?array
    {
        return $this->branchDropOffId;
    }

    /**
     * @return array|null
     */
    public function getPartnersId(): ?array
    {
        return $this->partnersId;
    }

    /**
     * @return array|null
     */
    public function getSellCodesId(): ?array
    {
        return $this->sellCodesId;
    }

    /**
     * @return array|null
     */
    public function getProductsId(): ?array
    {
        return $this->productsId;
    }

    /**
     * @return int|null
     */
    public function getStopSaleTypeId(): ?int
    {
        return $this->stopSaleTypeId;
    }

    /**
     * @return string|null
     */
    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    /**
     * @return string|null
     */
    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    /**
     * @return array|null
     */
    public function getRecurrencesId(): ?array
    {
        return $this->recurrencesId;
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
    public function getConnectedVehicle(): ?bool
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
}
