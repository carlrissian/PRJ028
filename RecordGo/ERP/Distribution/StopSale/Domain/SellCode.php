<?php

declare(strict_types=1);

namespace Distribution\StopSale\Domain;

class SellCode
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
     * Partner constructor.
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
     * @param array|null $sellCodeArray
     * @return self
     */
    final public static function createFromArray(?array $sellCodeArray): self
    {
        return new self(
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
