<?php

namespace Distribution\Supplier\Application\FilterSupplier;

class FilterSupplierQuery
{
    /**
     * @var string|null
     */
    private $sortBy;

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
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $vatNumber;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var int|null
     */
    private $state;


    public function __construct(
        ?string $sortBy,
        ?string $order,
        ?int $offset,
        ?int $limit,
        ?int $id,
        ?string $name,
        ?string $vatNumber,
        ?string $city,
        ?int $state
    ) {
        $this->sortBy = $sortBy;
        $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->id = $id;
        $this->name = $name;
        $this->vatNumber = $vatNumber;
        $this->city = $city;
        $this->state = $state;
    }

    /**
     * Get the value of sortBy
     *
     * @return string|null
     */
    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    /**
     * Get the value of order
     *
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * Get the value of offset
     *
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * Get the value of limit
     *
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Get the value of id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the value of vatNumber
     *
     * @return string|null
     */
    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    /**
     * Get the value of city
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Get the value of state
     *
     * @return int|null
     */
    public function getState(): ?int
    {
        return $this->state;
    }
}
