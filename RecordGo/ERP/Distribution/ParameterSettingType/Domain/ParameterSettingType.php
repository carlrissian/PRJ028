<?php

declare(strict_types=1);

namespace Distribution\ParameterSettingType\Domain;

class ParameterSettingType
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
     * ParameterSettingType constructor.
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
}
