<?php

namespace Distribution\StopSale\Application\FilterStopSale;

final class FilterStopSaleQuery
{
    /**
     * @var string|null
     */
    private $sort;

    /**
     * @var string|null
     */
    private $order;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var array|null
     */
    private $departmentId;

    /**
     * @var int|null
     */
    private $categoryId;

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
     * @var array|null
     */
    private $stopSaleTypeId;

    /**
     * @var int|null
     */
    private $stopSaleStatusId;

    /**
     * @var bool|null
     */
    private $connectedVehicle;

    /**
     * @var string|null
     */
    private $creationDateFrom;

    /**
     * @var string|null
     */
    private $creationDateTo;

    /**
     * FilterStopSaleQuery constructor.
     *
     * @param string|null $sort
     * @param string|null $order
     * @param integer|null $offset
     * @param integer|null $limit
     * @param array|null $departmentId
     * @param integer|null $categoryId
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
     * @param array|null $stopSaleTypeId
     * @param integer|null $stopSaleStatusId
     * @param boolean|null $connectedVehicle
     * @param string|null $creationDateFrom
     * @param string|null $creationDateTo
     */
    public function __construct(
        ?string $sort,
        ?string $order,
        ?int $offset,
        ?int $limit,
        ?array $departmentId,
        ?int $categoryId,
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
        ?array $stopSaleTypeId,
        ?int $stopSaleStatusId,
        ?bool $connectedVehicle,
        ?string $creationDateFrom,
        ?string $creationDateTo
    ) {
        $this->sort = $sort;
        $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->departmentId = $departmentId;
        $this->categoryId = $categoryId;
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
        $this->stopSaleStatusId = $stopSaleStatusId;
        $this->connectedVehicle = $connectedVehicle;
        $this->creationDateFrom = $creationDateFrom;
        $this->creationDateTo = $creationDateTo;
    }

    /**
     * @return string|null
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return array|null
     */
    public function getDepartmentId(): ?array
    {
        return $this->departmentId;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
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
     * @return array|null
     */
    public function getStopSaleTypeId(): ?array
    {
        return $this->stopSaleTypeId;
    }

    /**
     * @return int|null
     */
    public function getStopSaleStatusId(): ?int
    {
        return $this->stopSaleStatusId;
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
    public function getCreationDateFrom(): ?string
    {
        return $this->creationDateFrom;
    }

    /**
     * @return string|null
     */
    public function getCreationDateTo(): ?string
    {
        return $this->creationDateTo;
    }
}
