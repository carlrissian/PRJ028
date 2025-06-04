<?php

declare(strict_types=1);

namespace Distribution\Country\Infrastructure;

use Closure;
use Distribution\Country\Domain\Country;
use Distribution\Country\Domain\CountryCollection;
use Distribution\Country\Domain\CountryCriteria;
use Distribution\Country\Domain\CountryGetByResponse;
use Distribution\Country\Domain\CountryRepository;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;

class CountryRepositorySap extends RepositoryHelper implements CountryRepository
{
    private const PREFIX_FUNCTION_NAME = 'Country/CountryRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(CountryCriteria $criteria): CountryGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new CountryCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TCountryResponse', $collection, Closure::fromCallable([$this, 'arrayToCountry']));

            return new CountryGetByResponse($collection, $totalRows);

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }



    final public function arrayToCountry(array $countryArray): Country
    {
        return Country::createFromArray($countryArray);
    }
}
