<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\FilterVehicleHistory;

class FilterVehicleHistoryQuery
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
     * @var int
     */
    private int $vehicleId;

    /**
     * @var int|null
     */
    private ?int $originStatusId;

    /**
     * @var int|null
     */
    private ?int $endStatusId;

    /**
     * @var string|null
     */
    private ?string $statusChangeDateFrom;

    /**
     * @var string|null
     */
    private ?string $statusChangeDateTo;

    /**
     * FilterVehicleHistoryQuery constructor.
     * 
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $sort
     * @param string|null $order
     * @param int $vehicleId
     * @param int|null $originStatusId
     * @param int|null $endStatusId
     * @param string|null $statusChangeDateFrom
     * @param string|null $statusChangeDateTo
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $sort,
        ?string $order,
        int $vehicleId,
        ?int $originStatusId,
        ?int $endStatusId,
        ?string $statusChangeDateFrom,
        ?string $statusChangeDateTo
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->sort = $sort;
        $this->order = $order;
        $this->vehicleId = $vehicleId;
        $this->originStatusId = $originStatusId;
        $this->endStatusId = $endStatusId;
        $this->statusChangeDateFrom = $statusChangeDateFrom;
        $this->statusChangeDateTo = $statusChangeDateTo;
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
     * @return int
     */
    public function getVehicleId(): int
    {
        return $this->vehicleId;
    }

    /**
     * @return int|null
     */
    public function getOriginStatusId(): ?int
    {
        return $this->originStatusId;
    }

    /**
     * @return int|null
     */
    public function getEndStatusId(): ?int
    {
        return $this->endStatusId;
    }

    /**
     * @return string|null
     */
    public function getStatusChangeDateFrom(): ?string
    {
        return $this->statusChangeDateFrom;
    }

    /**
     * @return string|null
     */
    public function getStatusChangeDateTo(): ?string
    {
        return $this->statusChangeDateTo;
    }
}
