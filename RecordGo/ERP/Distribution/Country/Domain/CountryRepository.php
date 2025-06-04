<?php
declare(strict_types=1);

namespace Distribution\Country\Domain;


interface CountryRepository
{
    /**
     * @param CountryCriteria $countryCriteria
     * @return CountryGetByResponse
     */
    public function getBy(CountryCriteria $countryCriteria): CountryGetByResponse;
}
