<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;


/**
 * Class Region
 * @package Distribution\Vehicle\Domain
 */
class Region
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
     * @param array|null $regionArray
     * @return self
     */
    public static function createFromArray(?array $regionArray): self
    {
        return new self(
            intval($regionArray['ID']),
            $regionArray['REGIONNAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'REGIONNAME' => $this->getName(),
        ];
    }
}
