<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class Supplier
 * @package Distribution\Vehicle\Domain
 */
class Supplier
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
     * @param array|null $supplierArray
     * @return self
     */
    public static function createFromArray(?array $supplierArray): self
    {
        return new self(
            intval($supplierArray['ID']),
            $supplierArray['NAMESOCIAL'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'NAMESOCIAL' => $this->getName(),
        ];
    }
}
