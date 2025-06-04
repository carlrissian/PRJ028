<?php
declare(strict_types=1);


namespace Distribution\BusinessUnit\Domain;


use Shared\Domain\GetByResponse;

/**
 * Class BusinessUnitGetByResponse
 * @method BusinessUnitCollection getCollection()
 */

class BusinessUnitGetByResponse extends GetByResponse
{
    /**
     * BusinessUnitGetByResponse constructor.
     * @param BusinessUnitCollection $collection
     * @param int $totalRows
     */
    public function __construct(BusinessUnitCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}