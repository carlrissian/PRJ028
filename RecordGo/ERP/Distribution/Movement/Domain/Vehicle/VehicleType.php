<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\Vehicle;

class VehicleType
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * VehicleType constructor.
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
}
