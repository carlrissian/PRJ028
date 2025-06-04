<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class VehicleType
 * @package Distribution\Vehicle\Domain
 */
class VehicleType
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
     * @param array|null $vehicleTypeArray
     * @return self
     */
    public static function createFromArray(?array $vehicleTypeArray): self
    {
        return new self(
            intval($vehicleTypeArray['ID']),
            $vehicleTypeArray['CARTYPENAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'CARTYPENAME' => $this->getName(),
        ];
    }
}
