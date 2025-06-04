<?php

declare(strict_types=1);


namespace Distribution\Movement\Domain\VehicleFilter;


class VehicleStatus
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
     * Status constructor.
     * 
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
     * @param array|null $vehicleStatusArray
     * @return VehicleStatus
     */
    public static function createFromArray(?array $vehicleStatusArray): VehicleStatus
    {
        return new self(
            intval($vehicleStatusArray['ID']),
          $vehicleStatusArray['STATUSNAME']
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
