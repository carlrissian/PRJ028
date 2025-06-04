<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Domain;

/**
 * Class Acriss
 * @package Distribution\Acriss\Domain
 */
class Acriss
{
    /**
     * @var integer|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $vehicleGroupName;


    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $vehicleGroupName
     */
    public function __construct(
        ?int $id,
        ?string $name = null,
        ?string $vehicleGroupName = null

    ) {
        $this->id = $id;
        $this->name = $name;
        $this->vehicleGroupName = $vehicleGroupName;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return string|null
     */
    public function getVehicleGroupName(): ?string
    {
        return $this->vehicleGroupName;
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
