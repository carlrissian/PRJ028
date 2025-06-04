<?php

namespace Distribution\Location\Application\Filter;

class FilterLocationQuery
{
    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var string|null
     */
    private $sort;

    /**
     * @var string|null
     */
    private $order;

    /**
     * @var bool|null
     */
    private $hasPartner;

    /**
     * FilterLocationQuery constructor.
     *
     * @param integer|null $limit
     * @param integer|null $offset
     * @param string|null $sort
     * @param string|null $order
     * @param boolean|null $hasPartner
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $sort,
        ?string $order,
        ?bool $hasPartner
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->sort = $sort;
        $this->order = $order;
        $this->hasPartner = $hasPartner;
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
     * @return bool|null
     */
    public function hasPartner(): ?bool
    {
        return $this->hasPartner;
    }
}
