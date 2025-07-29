<?php

namespace Distribution\StopSale\Domain;

/**
 * Class CarGroup
 * @package Distribution\CarGroup\Domain
 */
final class CarGroup
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
    private function __construct(int $id, ?string $name)
    {
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
     * @param int $id
     * @param string|null $name
     */
    public static function create(
        int $id,
        ?string $name = null
    ): self {
        return new self($id, $name);
    }

    /**
     * @param array|null $carGroupArray
     * @return self
     */
    public static function createFromArray(?array $carGroupArray): self
    {
        return self::create(
            intval($carGroupArray['ID']),
            $carGroupArray['VEHICLEGROUPNAME'] ?? null
        );
    }
}
