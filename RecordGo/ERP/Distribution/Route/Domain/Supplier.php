<?php

declare(strict_types=1);

namespace Distribution\Route\Domain;

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
     * Supplier constructor.
     * 
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(
        ?int $id,
        ?string $name = null
    ) {
        $this->id = $id;
        $this->name = $name;
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
     * @param array $supplierArray
     * @return self
     */
    public static function createFromArray(array $supplierArray): self
    {
        return new self(
            intval($supplierArray['ID']),
            $supplierArray['NAMESOCIAL'] ?? null
        );
    }
}
