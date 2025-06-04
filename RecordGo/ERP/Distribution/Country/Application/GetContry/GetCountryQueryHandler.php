<?php
declare(strict_types=1);


namespace Distribution\Country\Application\GetContry;


use Distribution\Country\Domain\CountryCriteria;
use Distribution\Country\Domain\CountryRepository;

class GetCountryQueryHandler
{
    /**
     * @var CountryRepository
     */
    private CountryRepository $countryRepository;

    /**
     * GetCountryHandler constructor.
     * @param CountryRepository $countryRepository
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function handle(GetCountryQuery $getCountryQuery): GetCountryQueryHandlerResponse
    {
        $response = $this->countryRepository->getBy(new CountryCriteria());

        return new GetCountryQueryHandlerResponse($response->getCollection(), $response->getTotalRows());
    }
}