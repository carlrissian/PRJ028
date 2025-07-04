<?php

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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param int $id
     * @param string|null $name
     */
    public static function create(int $id, ?string $name = null)
    {
        $parameterSettingType = new self($id, $name);
        return $parameterSettingType;
    }


    /**
     * @param array|null $parameterSettingTypeArray
     * @return self
     */
    final public static function createFromArray(?array $parameterSettingTypeArray): self
    {
        return self::create(
            intval($parameterSettingTypeArray['ID']),
            $parameterSettingTypeArray['NAME'] ?? null
        );
    }
}
