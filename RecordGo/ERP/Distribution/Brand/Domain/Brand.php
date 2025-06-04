<?php

declare(strict_types=1);

namespace Distribution\Brand\Domain;

use JsonSerializable;
use Shared\Utils\DataValidation;

class Brand implements JsonSerializable
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
     * Brand constructor.
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


    /**
     * @param array|null $brandArray
     * @return Brand
     */
    public static function createFromArray(?array $brandArray): Brand
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($brandArray, 'ID')),
            $helper->arrayExistOrNull($brandArray, 'BRANDNAME')
        );
    }
}
