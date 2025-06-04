<?php

declare(strict_types=1);

namespace Distribution\StopSale\Domain;

class StopSaleType
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * StopSaleType constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $stopSaleTypeArray
     * @return self
     */
    final public static function createFromArray(?array $stopSaleTypeArray): self
    {
        return new self(
            intval($stopSaleTypeArray['ID']),
            $stopSaleTypeArray['NAME'] ?? null
        );
    }
}
