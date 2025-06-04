<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\VehicleFilter;


/**
 * Class CarGroup
 * @package Distribution\Movement\Domain\VehicleFilter
 */
class CarGroup
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
     * @return int|null
     */
    public function getId(): ?int
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
     * @param array|null $carGroupArray
     * @return CarGroup
     */
    public static function createFromArray(?array $carGroupArray): CarGroup
    {
        return new self(
            intval($carGroupArray['ID']),
            $carGroupArray['VEHICLEGROUPNAME']
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
