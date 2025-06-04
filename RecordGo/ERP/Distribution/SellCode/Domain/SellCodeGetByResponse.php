<?php

namespace Distribution\SellCode\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class SellCodeGetByResponse
 * @method SellCodeCollection getCollection()
 */
class SellCodeGetByResponse extends GetByResponse
{
    /**
     * SellCodeGetByResponse constructor.
     * 
     * @param SellCodeCollection $collection
     * @param int $totalRows
     */
    public function __construct(SellCodeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
