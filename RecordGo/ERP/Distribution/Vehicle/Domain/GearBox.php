<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class GearBox
 * @package Distribution\Vehicle\Domain
 */
class GearBox
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
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $gearBoxArray
     * @return self
     */
    public static function createFromArray(?array $gearBoxArray): self
    {
        return new self(
            intval($gearBoxArray['ID']),
            $gearBoxArray['GEARBOXTYPE'] ?? null
        );
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'GEARBOXTYPE' => $this->getName(),
        ];
    }
}
