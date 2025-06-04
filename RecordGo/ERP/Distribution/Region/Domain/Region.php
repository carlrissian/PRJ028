<?php

declare(strict_types=1);

namespace Distribution\Region\Domain;

use JsonSerializable;
use Distribution\Country\Domain\Country;
use Shared\Utils\DataValidation;

class Region implements JsonSerializable
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
     * @var Country|null
     */
    private ?Country $country;

    /**
     * @param int $id
     * @param string|null $name
     * @param Country|null $country
     */
    public function __construct(int $id, ?string $name = null, ?Country $country = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->country = $country;
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
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }



    /**
     * @param array|null $regionArray
     * @return Region
     */
    public static function createFromArray(?array $regionArray): Region
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($regionArray, 'ID')),
            $helper->arrayExistOrNull($regionArray, 'REGIONNAME'),
            // FIXME cual de los 2?
            // (isset($regionArray['Country'])) ? Country::createFromArray($regionArray['Country']) : null
            (isset($regionArray['Countries'])) ? Country::createFromArray($regionArray['Countries']) : null
        );
    }
}
