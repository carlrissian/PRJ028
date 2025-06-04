<?php

declare(strict_types=1);

namespace Distribution\VehicleStatus\Domain;

use JsonSerializable;

class VehicleStatus implements JsonSerializable
{
    // FIXME eliminar una vez se devuelvan todas las constantes desde base de datos
    const ON_RENT = 1;
    const SALE = 6;
    const AVAILABLE = 16;
    const STOCK = 17;
    const INTERNAL_MOVEMENT = 26;

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * Status constructor.
     * 
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
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
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }


    /**
     * @param array|null $vehicleStatusArray
     * @return VehicleStatus
     */
    public static function createFromArray(?array $vehicleStatusArray): VehicleStatus
    {
        return new self(
            intval($vehicleStatusArray['ID']),
            $vehicleStatusArray['STATUSNAME'] ?? $vehicleStatusArray['NAME'] ?? null
        );
    }
}
