<?php
declare(strict_types=1);


namespace Distribution\Country\Application\GetContry;


use Distribution\Country\Domain\CountryCollection;
use Shared\Domain\GetByResponse;

class GetCountryQueryHandlerResponse extends GetByResponse
{
    public function __construct(CountryCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}