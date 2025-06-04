<?php
declare(strict_types=1);


namespace Distribution\Carrier\Domain;


use JsonSerializable;

class Carrier implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $name;

    /**
     * Carrier constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
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

    public static function fromArray(array $array)
    {
        return new self($array['id'], $array['name']);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }


    public function jsonSerialize()
    {
        return $this->toArray();
    }

}