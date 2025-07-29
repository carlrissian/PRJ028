<?php

namespace Distribution\StopSale\Domain;

final class StopSaleType
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
    private function __construct(int $id, ?string $name)
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
     * @param int $id
     * @param string|null $name
     */
    public static function create(int $id, ?string $name = null): self
    {
        return new self($id, $name);
    }

    /**
     * @param array|null $stopSaleTypeArray
     * @return self
     */
    public static function createFromArray(?array $stopSaleTypeArray): self
    {
        return self::create(
            intval($stopSaleTypeArray['ID']),
            $stopSaleTypeArray['NAME'] ?? null
        );
    }
}
