<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

/**
 * Class VehicleGroup
 * @package Distribution\Vehicle\Domain
 */
class VehicleGroup
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
     * @param array|null $vehicleGroupArray
     * @return self
     */
    public static function createFromArray(?array $vehicleGroupArray): self
    {
        return new self(
            intval($vehicleGroupArray['ID']),
            $vehicleGroupArray['VEHICLEGROUPNAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'VEHICLEGROUPNAME' => $this->getName(),
        ];
    }
}
