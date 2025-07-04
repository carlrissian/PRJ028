<?php

namespace Distribution\ParameterSetting\Domain;

class Area
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
    private function __construct(int $id, ?string $name = null)
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
    public static function create(int $id, ?string $name = null): self
    {
        $area = new self($id, $name);
        return $area;
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
