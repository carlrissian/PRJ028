<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\FilterCommercialGroup;

class FilterCommercialGroupQuery
{
    /**
     * @var int
     */
    private int $limit;

    /**
     * @var int
     */
    private int $offset;

    /**
     * @var array|null
     */
    private ?array $commercialGroupIds;

    /**
     * @var string|null
     */
    private ?string $acrissName;

    /**
     * @var bool|null
     */
    private ?bool $active;


    /**
     * @param int $limit
     * @param int $offset
     * @param array|null $commercialGroupIds
     * @param string|null $acrissName
     * @param bool|null $active
     */
    public function __construct(
        int $limit,
        int $offset,
        ?array $commercialGroupIds,
        ?string $acrissName,
        ?bool $active
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->commercialGroupIds = $commercialGroupIds;
        $this->acrissName = $acrissName;
        $this->active = $active;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return array|null
     */
    public function getCommercialGroupIds(): ?array
    {
        return $this->commercialGroupIds;
    }

    /**
     * @return string|null
     */
    public function getAcrissName(): ?string
    {
        return $this->acrissName;
    }

    /**
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }
}
