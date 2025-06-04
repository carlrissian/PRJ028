<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class PurchaseMethod
 * @package Distribution\Vehicle\Domain
 */
class PurchaseMethod
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $name = null
    ) {
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
     * @param array|null $purchaseMethodArray
     * @return self
     */
    public static function createFromArray(?array $purchaseMethodArray): self
    {
        return new self(
            intval($purchaseMethodArray['ID']),
            $purchaseMethodArray['PURCHASEMETHODNAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'PURCHASEMETHODNAME' => $this->getName(),
        ];
    }
}
