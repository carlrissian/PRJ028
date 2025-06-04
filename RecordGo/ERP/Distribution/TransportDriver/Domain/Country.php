<?php

namespace Distribution\TransportDriver\Domain;

use Shared\Utils\DataValidation;

class Country
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string|null
     */
    private $name;

    /**
     * Country constructor
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


    /**
     * @param array|null $countryArray
     * @return Country
     */
    public static function createFromArray(?array $countryArray): Country
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($countryArray, 'ID')),
            $helper->arrayExistOrNull($countryArray, 'COUNTRYDESCRIPTION'),
        );
    }
}
