<?php
declare(strict_types=1);


namespace Distribution\StopSaleType\Domain;


use Shared\Domain\GetByResponse;

class StopSaleTypeGetByResponse extends GetByResponse
{
    /**
     * StopSaleGetByResponse constructor.
     * @param StopSaleTypeCollection $collection
     * @param int $totalRows
     */
    public function __construct(StopSaleTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}