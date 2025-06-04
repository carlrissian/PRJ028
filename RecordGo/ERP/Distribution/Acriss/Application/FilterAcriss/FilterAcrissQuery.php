<?php

namespace Distribution\Acriss\Application\FilterAcriss;

class FilterAcrissQuery
{
    /**
     * @var int|null
     */
    private ?int $limit;

    /**
     * @var int|null
     */
    private ?int $offset;

    /**
     * @var string|null
     */
    private ?string $sort;

    /**
     * @var string|null
     */
    private ?string $order;

    /**
     * @var array|null
     */
    private ?array $commercialGroupIds;

    /**
     * @var array|null
     */
    private ?array $carGroupIds;

    /**
     * @var array|null
     */
    private ?array $carClassIds;

    /**
     * @var array|null
     */
    private ?string $acrissName;

    /**
     * @var array|null
     */
    private ?array $motorizationTypeIds;

    /**
     * @var array|null
     */
    private ?array $gearBoxIds;

    /**
     * @var array|null
     */
    private ?bool $acrissStatus;

    /**
     * FilterAcrissQuery constructor.
     *
     * @param integer|null $limit
     * @param integer|null $offset
     * @param string|null $sort
     * @param string|null $order
     * @param array|null $commercialGroupIds
     * @param array|null $carGroupIds
     * @param array|null $carClassIds
     * @param string|null $acrissName
     * @param array|null $motorizationTypeIds
     * @param array|null $gearBoxIds
     * @param boolean|null $acrissStatus
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $sort,
        ?string $order,
        ?array $commercialGroupIds,
        ?array $carGroupIds,
        ?array $carClassIds,
        ?string $acrissName,
        ?array $motorizationTypeIds,
        ?array $gearBoxIds,
        ?bool $acrissStatus
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->sort = $sort;
        $this->order = $order;
        $this->commercialGroupIds = $commercialGroupIds;
        $this->carGroupIds = $carGroupIds;
        $this->carClassIds = $carClassIds;
        $this->acrissName = $acrissName;
        $this->motorizationTypeIds = $motorizationTypeIds;
        $this->gearBoxIds = $gearBoxIds;
        $this->acrissStatus = $acrissStatus;
    }
    

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
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
     * @return array|null
     */
    public function getCommercialGroupIds(): ?array
    {
        return $this->commercialGroupIds;
    }

    /**
     * @return array|null
     */
    public function getCarGroupIds(): ?array
    {
        return $this->carGroupIds;
    }

    /**
     * @return array|null
     */
    public function getCarClassIds(): ?array
    {
        return $this->carClassIds;
    }

    /**
     * @return array|null
     */
    public function getAcrissName(): ?string
    {
        return $this->acrissName;
    }

    /**
     * @return array|null
     */
    public function getMotorizationTypeIds(): ?array
    {
        return $this->motorizationTypeIds;
    }

    /**
     * @return array|null
     */
    public function getGearBoxIds(): ?array
    {
        return $this->gearBoxIds;
    }

    /**
     * @return array|null
     */
    public function getAcrissStatus(): ?bool
    {
        return $this->acrissStatus;
    }
}
