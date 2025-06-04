<?php

declare(strict_types=1);

namespace Distribution\StopSale\Domain;

class StopSaleCategory
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
     * StopSaleCategory constructor.
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
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $stopSaleCategoryArray
     * @return self
     */
    final public static function createFromArray(?array $stopSaleCategoryArray): self
    {
        return new self(
            intval($stopSaleCategoryArray['ID']),
            $stopSaleCategoryArray['NAME'] ?? null
        );
    }
}
