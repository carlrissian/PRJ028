<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

class Supplier
{
    /**
     * @var int|null
     */
    private ?int $id;


    /**
     * @var string|null
     */
    private ?string $name;
    /**
     * @var SupplierType|null
     */
    private ?SupplierType $supplierType;


    /**
     * Supplier constructor.
     * @param int|null $id
     * @param string|null $name
     * @param SupplierType|null $supplierType
     */
    public function __construct(
        ?int $id,
        ?string $name = null,
        ?SupplierType $supplierType = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->supplierType = $supplierType;
    }


    /**
     * Get the value of id
     *
     * @return int|null
     */
    final public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * Get the value of name
     *
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the value of supplierType
     *
     * @return SupplierType|null
     */
    final public function getSupplierType(): ?SupplierType
    {
        return $this->supplierType;
    }


    /**
     * @param array|null $supplierArray
     * @return self|null
     */
    public static function createFromArray(?array $supplierArray): ?self
    {
        return (is_array($supplierArray)) ? new self(
            intval($supplierArray['ID'] ?? $supplierArray['PROVIDERID']),
            $supplierArray['NAMESOCIAL'],
            isset($supplierArray['SUPPLIERTYPE']) ? SupplierType::createFromArray($supplierArray['SUPPLIERTYPE']) : null
        ) : null;
    }

    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'NAMESOCIAL' => $this->getName(),
            'SUPPLIERTYPE' => ($this->getSupplierType()) ? $this->getSupplierType()->toArray() : null,
        ];
    }
}
