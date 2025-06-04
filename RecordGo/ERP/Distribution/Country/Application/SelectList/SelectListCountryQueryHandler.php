<?php

namespace Distribution\Country\Application\SelectList;

use Shared\Utils\Utils;
use Distribution\Country\Domain\CountryCriteria;
use Distribution\Country\Domain\CountryRepository;

class SelectListCountryQueryHandler
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * SelectListCountryQueryHandler constructor.
     *
     * @param CountryRepository $countryRepository
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @return SelectListCountryResponse
     */
    public function handle(): SelectListCountryResponse
    {
        $countryCollection = $this->countryRepository->getBy(new CountryCriteria())->getCollection();
        return new SelectListCountryResponse(Utils::createSelect($countryCollection));
    }
}
