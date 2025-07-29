<?php

namespace Distribution\StopSale\Domain;

final class StopSaleCategory
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
    private function __construct(int $id, ?string $name)
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
     * @param int $id
     * @param string|null $name
     */
    public static function create(int $id, ?string $name = null): self
    {
        return new self($id, $name);
    }

    /**
     * @param array|null $stopSaleCategoryArray
     * @return self
     */
    public static function createFromArray(?array $stopSaleCategoryArray): self
    {
        return self::create(
            intval($stopSaleCategoryArray['ID']),
            $stopSaleCategoryArray['NAME'] ?? null
        );
    }
}
