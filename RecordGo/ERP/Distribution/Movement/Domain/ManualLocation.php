<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Distribution\Movement\Domain\Vehicle\Country;

class ManualLocation
{
    const ORIGIN = 1;
    const DESTINATION = 2;

    /**
     * @var Country
     */
    private Country $country;

    /**
     * @var State
     */
    private State $state;

    /**
     * @var string
     */
    private string $notes;

    /**
     * ManualLocation constructor.
     * 
     * @param Country $country
     * @param State $state
     * @param string $notes
     */
    public function __construct(Country $country, State $state, string $notes)
    {
        $this->country = $country;
        $this->state = $state;
        $this->notes = $notes;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getNotes(): string
    {
        return $this->notes;
    }


    /**
     * @param array|null $manualLocationArray
     * @return self
     */
    public static function createFromArray(?array $manualLocationArray, int $type): self
    {
        switch ($type) {
            case ManualLocation::ORIGIN:
                return new self(
                    new Country(
                        intval($manualLocationArray['COUNTRY']['ORIGINEXTCOUNTRYID']),
                        $manualLocationArray['COUNTRY']['COUNTRYDESCRIPTION'] ?? null,
                        $manualLocationArray['COUNTRY']['COUNTRYISO'] ?? null
                    ),
                    new State(
                        intval($manualLocationArray['PROVINCE']['ORIGINEXTSTATEID']),
                        $manualLocationArray['PROVINCE']['STATENAME'] ?? null
                    ),
                    $manualLocationArray['ORIGINEXTLOCATIONNOTE'] ?? null
                );

            case ManualLocation::DESTINATION:
                return new self(
                    new Country(
                        intval($manualLocationArray['COUNTRY']['DESTINYEXTCOUNTRYID']),
                        $manualLocationArray['COUNTRY']['COUNTRYDESCRIPTION'] ?? null,
                        $manualLocationArray['COUNTRY']['COUNTRYISO'] ?? null
                    ),
                    new State(
                        intval($manualLocationArray['PROVINCE']['DESTINYEXTSTATEID']),
                        $manualLocationArray['PROVINCE']['STATENAME'] ?? null
                    ),
                    $manualLocationArray['DESTINYEXTLOCATIONNOTE'] ?? null
                );
        }
    }

    /**
     * @return array
     */
    public function toArray(int $type): array
    {
        switch ($type) {
            case ManualLocation::ORIGIN:
                return [
                    'ORIGINEXTCOUNTRYID' => $this->getCountry()->getId(),
                    'ORIGINEXTSTATEID' => $this->getState()->getId(),
                    'ORIGINEXTLOCATIONNOTE' => $this->getNotes(),
                ];

            case ManualLocation::DESTINATION:
                return [
                    'DESTINYEXTCOUNTRYID' => $this->getCountry()->getId(),
                    'DESTINYEXTSTATEID' => $this->getState()->getId(),
                    'DESTINYEXTLOCATIONNOTE' => $this->getNotes(),
                ];
        }
    }
}
