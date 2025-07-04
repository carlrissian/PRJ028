<?php

namespace Distribution\ParameterSetting\Domain;

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
     * @param int $id
     * @param string|null $name
     */
    private function __construct(int $id, ?string $name)
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
     * @param int $id
     * @param string|null $name
     */
    public static function create(int $id, ?string $name = null): self
    {
        $carGroup = new self($id, $name);
        return $carGroup;
    }
}
