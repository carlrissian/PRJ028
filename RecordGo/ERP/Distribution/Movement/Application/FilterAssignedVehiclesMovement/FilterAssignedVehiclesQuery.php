<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterAssignedVehiclesMovement;

class FilterAssignedVehiclesQuery
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
    private ?string $order;

    /**
     * @var string|null
     */
    private ?string $sort;

    /**
     * @var int
     */
    private int $movementId;

    /**
     * FilterAssignedVehiclesQuery constructor.
     *
     * @param integer|null $limit
     * @param integer|null $offset
     * @param string|null $order
     * @param string|null $sort
     * @param integer $movementId
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $order,
        ?string $sort,
        int $movementId
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $this->sort = $sort;
        $this->movementId = $movementId;
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
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * @return string|null
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }
}
