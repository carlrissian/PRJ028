<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class Brand
 * @package Distribution\Vehicle\Domain
 */
class Brand
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
     * @param array|null $brandArray
     * @return self
     */
    public static function createFromArray(?array $brandArray): self
    {
        return new self(
            intval($brandArray['ID']),
            $brandArray['BRANDNAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'BRANDNAME' => $this->getName(),
        ];
    }
}
