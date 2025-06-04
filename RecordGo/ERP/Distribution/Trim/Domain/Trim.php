<?php

declare(strict_types=1);

namespace Distribution\Trim\Domain;

use JsonSerializable;
use Shared\Utils\DataValidation;

class Trim implements JsonSerializable
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
     * Trim constructor.
     * 
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


    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $array)
    {
        return new self($array['id'], $array['name']);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }


    /**
     * @param array|null $trimArray
     * @return Trim
     */
    public static function createFromArray(?array $trimArray): Trim
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($trimArray, 'ID')),
            $helper->arrayExistOrNull($trimArray, 'TRIMNAME')
        );
    }
}
