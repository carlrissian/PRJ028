<?php

declare(strict_types=1);

namespace Distribution\Route\Domain;

class TransportMethod
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
     * TransportMethod constructor.
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
     * @param array $transportMethodArray
     * @return self
     */
    public static function createFromArray(array $transportMethodArray): self
    {
        return new self(
            intval($transportMethodArray['ID']),
            $transportMethodArray['NAME'] ?? null
        );
    }
}
