<?php

declare(strict_types=1);

namespace Distribution\Country\Domain;

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
    private ?string $countryCode;

    /**
     * Country constructor.
     * @param int|null $id
     * @param string|null $name
     * @param string|null $countryCode
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $countryCode = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->countryCode = $countryCode;
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
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
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
            $helper->arrayExistOrNull($countryArray, 'COUNTRYISO')
        );
    }
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'COUNTRYDESCRIPTION' => $this->getName(),
            'COUNTRYISO' => $this->getCountryCode()
        ];
    }
}
