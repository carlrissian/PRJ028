<?php

declare(strict_types=1);

namespace Distribution\PurchaseMethod\Domain;

class PurchaseMethod
{
    // FIXME recibir constantes de base de datos y sustituir
    const RISK = 1;
    const BUYBACK = 2;
    const RENTING = 3;

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * PurchaseMethod constructor.
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
     * @param array $purchaseMethodArray
     * @return self
     */
    public static function createFromArray(array $purchaseMethodArray): self
    {
        return new self(
            intval($purchaseMethodArray['ID']),
            $purchaseMethodArray['NAME'] ?? null
        );
    }
}
