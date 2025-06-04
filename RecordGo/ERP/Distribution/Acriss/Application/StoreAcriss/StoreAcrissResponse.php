<?php

declare(strict_types=1);


namespace Distribution\Acriss\Application\StoreAcriss;


class StoreAcrissResponse
{
    /**
     * @var bool
     */
    private bool $created;

    /**
     * @var int
     */
    private int $id;

    /**
     * @var array|null
     */
    private ?array $childAcrissIds;

    /**
     * StoreAcrissResponse constructor.
     *
     * @param boolean $created
     * @param integer $id
     * @param array|null $childAcrissIds
     */
    public function __construct(
        bool $created,
        int $id,
        ?array $childAcrissIds = null
    ) {
        $this->created = $created;
        $this->id = $id;
        $this->childAcrissIds = $childAcrissIds;
    }

    /**
     * @return bool
     */
    public function isCreated(): bool
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array|null
     */
    public function getChildAcrissIds(): ?array
    {
        return $this->childAcrissIds;
    }
}
