<?php
declare(strict_types=1);


namespace Distribution\Country\Domain;

use Shared\Domain\GetByResponse;
/**
 * Class CountryGetByResponse
 * @method CountryCollection getCollection()
 */
class CountryGetByResponse  extends GetByResponse
{
    /**
     * CountryGetByResponse constructor.
     * @param CountryCollection $collection
     * @param int $totalRows
     */
    public function __construct(CountryCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}