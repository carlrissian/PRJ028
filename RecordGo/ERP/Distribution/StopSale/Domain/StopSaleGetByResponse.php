<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class StopSaleGetByResponse
 * @method StopSaleGetByResponse getCollection()
 */
final class StopSaleGetByResponse extends GetByResponse
{
    /**
     * StopSaleGetByResponse constructor.
     * @param StopSaleCollection $collection
     * @param int $totalRows
     */
    public function __construct(StopSaleCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
