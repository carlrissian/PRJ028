<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;


class SupplierType
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private string $name;

    /**
     * SupplierType constructor.
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param array|null $supplierTypeArray
     * @return self|null
     */
    public static function createFromArray(?array $supplierTypeArray): ?self
    {
        return (is_array($supplierTypeArray)) ? new self(
            intval($supplierTypeArray['PROVIDERCATID']),
            $supplierTypeArray['PROVIDERCATNAME']
        ) : null;
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'PROVIDERCATNAME' => $this->getName(),
        ];
    }
}
