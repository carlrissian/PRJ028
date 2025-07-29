<?php

namespace Distribution\StopSale\Domain;

final class SellCode
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
     * SellCode constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name)
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
     * @param array|null $sellCodeArray
     * @return self
     */
    public static function createFromArray(?array $sellCodeArray): self
    {
        return self::create(
            intval($sellCodeArray['ID']),
            $sellCodeArray['SELLCODENAME'] ?? null
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
