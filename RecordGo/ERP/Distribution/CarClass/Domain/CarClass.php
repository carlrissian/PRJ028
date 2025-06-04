<?php

declare(strict_types=1);

namespace Distribution\CarClass\Domain;

use JsonSerializable;

class CarClass implements JsonSerializable
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $acrissLetter;

    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $acrissLetter
     */
    public function __construct(?int $id, ?string $name = null, ?string $acrissLetter = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->acrissLetter = $acrissLetter;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return string|null
     */
    public function getAcrissLetter(): ?string
    {
        return $this->acrissLetter;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $array): CarClass
    {
        return new self($array['name'],  $array['id']);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }


    /**
     * @param array|null $carClassArray
     * @return CarClass
     */
    public static function createFromArray(?array $carClassArray): CarClass
    {
        return new self(
            intval($carClassArray['ID']),
            $carClassArray['CARCLASSNAME'] ?? null,
            $carClassArray['ACRISS1LETTER'] ?? null
        );
    }
}
