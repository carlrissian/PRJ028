<?php

declare(strict_types=1);

namespace Distribution\PurchaseType\Domain;

use Shared\Utils\DataValidation;

class PurchaseType
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
     * PurchaseType constructor.
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
     * @param array|null $purchaseTypeArray
     * @return PurchaseType
     */
    public static function createFromArray(?array $purchaseTypeArray): PurchaseType
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($purchaseTypeArray, 'ID')),
            $helper->arrayExistOrNull($purchaseTypeArray, 'PURCHASETYPENAME')
        );
    }
}
