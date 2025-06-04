<?php
declare(strict_types=1);

namespace Distribution\Country\Infrastructure;


use Distribution\Country\Domain\Country;
use Distribution\Country\Domain\CountryCollection;
use Distribution\Country\Domain\CountryCriteria;
use Distribution\Country\Domain\CountryGetByResponse;
use Distribution\Country\Domain\CountryRepository;


class CountryRepositoryFake implements CountryRepository
{
    /**
     * @var array
     */
    public array $countryList;

    public function __construct()
    {
        $this->countryList = [
            [ 'id' => 1, 'name' => 'España', 'countryCode' => 'ES'],
            [ 'id' => 2, 'name' => 'Francia', 'countryCode' => 'FR'],
            [ 'id' => 3, 'name' => 'Portugal', 'countryCode' => 'PT'],
            [ 'id' => 4, 'name' => 'Grecia', 'countryCode' => 'GR']
        ];
    }

    public function getBy(CountryCriteria $countryCriteria): CountryGetByResponse
    {
        $objectArray = [];
        foreach ($this->countryList as $country){
            $objectArray[] = new Country($country['id'], $country['name'], $country['countryCode']);
        }

        $countryCollection = new CountryCollection($objectArray);

        return new CountryGetByResponse($countryCollection, $countryCollection->count());
    }

}
