<?php

declare(strict_types=1);

namespace Distribution\StopSale\Domain;

/**
 * Class CarGroup
 * @package Distribution\CarGroup\Domain
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
     * CarGroup constructor.
     * 
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
     * @return self
     */
    final public static function createFromArray(?array $carGroupArray): self
    {
        return new self(
            intval($carGroupArray['ID']),
            $carGroupArray['VEHICLEGROUPNAME'] ?? null
        );
    }
}
