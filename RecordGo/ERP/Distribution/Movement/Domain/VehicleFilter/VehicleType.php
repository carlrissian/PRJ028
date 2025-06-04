<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\VehicleFilter;

class VehicleType
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * VehicleType constructor.
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param array|null $vehicleTypeArray
     * @return VehicleType
     */
    public static function createFromArray(?array $vehicleTypeArray): VehicleType
    {
        return new self(
            intval($vehicleTypeArray['ID']),
            $vehicleTypeArray['CARTYPENAME']
        );
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
        ];
    }
}
