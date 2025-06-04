<?php

namespace Distribution\Route\Application\Filter;

class FilterRouteQuery
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
     * @var int|null
     */
    private $transportMethodId;

    /**
     * @var int|null
     */
    private $providerId;

    /**
     * @var int|null
     */
    private $originBranchId;

    /**
     * @var int|null
     */
    private $destinationBranchId;

    /**
     * FilterRouteQuery constructor.
     *
     * @param integer|null $limit
     * @param integer|null $offset
     * @param string|null $sort
     * @param string|null $order
     * @param integer|null $transportMethodId
     * @param integer|null $providerId
     * @param integer|null $originBranchId
     * @param integer|null $destinationBranchId
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $sort,
        ?string $order,
        ?int $transportMethodId,
        ?int $providerId,
        ?int $originBranchId,
        ?int $destinationBranchId
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->sort = $sort;
        $this->order = $order;
        $this->transportMethodId = $transportMethodId;
        $this->providerId = $providerId;
        $this->originBranchId = $originBranchId;
        $this->destinationBranchId = $destinationBranchId;
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
     * @return int|null
     */
    public function getTransportMethodId(): ?int
    {
        return $this->transportMethodId;
    }

    /**
     * @return int|null
     */
    public function getProviderId(): ?int
    {
        return $this->providerId;
    }

    /**
     * @return int|null
     */
    public function getOriginBranchId(): ?int
    {
        return $this->originBranchId;
    }

    /**
     * @return int|null
     */
    public function getDestinationBranchId(): ?int
    {
        return $this->destinationBranchId;
    }
}
