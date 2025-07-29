<?php

namespace Distribution\StopSale\Domain;

final class Product
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
     * Product constructor.
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
    public function getId(): int
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
     * @param array|null $productArray
     * @return self
     */
    public static function createFromArray(?array $productArray): self
    {
        return self::create(
            intval($productArray['ID']),
            $productArray['NAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
        ];
    }
}
