<?php
declare(strict_types=1);


namespace Distribution\Location\Application\Shared;


class AbstractLocationQuery
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
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $sort
     * @param string|null $order
     */
    public function __construct(?int $limit, ?int $offset, ?string $sort, ?string $order)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->sort = $sort;
        $this->order = $order;
    }

    /**
     * @return int|null
     */
    final public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    final public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return string|null
     */
    final public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @return string|null
     */
    final public function getOrder(): ?string
    {
        return $this->order;
    }
}