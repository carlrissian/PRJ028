<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Utils\DataValidation;

final class Country
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
    private ?string $iso;

    /**
     * Country constructor.
     * 
     * @param int|null $id
     * @param string|null $name
     * @param string|null $iso
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $iso = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->iso = $iso;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getISO(): ?string
    {
        return $this->iso;
    }


    /**
     * @param array|null $countryArray
     * @return Country
     */
    public static function createFromArray(?array $countryArray): Country
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($countryArray, 'EXTDRIVERCOUNTRYID')),
            $helper->arrayExistOrNull($countryArray, 'COUNTRYDESCRIPTION'),
            $helper->arrayExistOrNull($countryArray, 'COUNTRYISO')
        );
    }
}
