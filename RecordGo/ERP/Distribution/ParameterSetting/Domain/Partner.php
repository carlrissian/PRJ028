<?php

namespace Distribution\ParameterSetting\Domain;

class Partner
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * Partner constructor.
     * @param int|null $id
     * @param string $name
     */
    private function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    final public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param int|null $id
     * @param string $name
     */
    public static function create(?int $id, string $name): self
    {
        $partner = new self($id, $name);
        return $partner;
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
