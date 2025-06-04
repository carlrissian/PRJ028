<?php

namespace Distribution\Product\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class ProductGetByResponse
 * @method ProductGetByResponse getCollection()
 */
class ProductGetByResponse extends GetByResponse
{
    /**
     * ProductGetByResponse constructor.
     * 
     * @param ProductCollection $collection
     * @param int $totalRows
     */
    public function __construct(ProductCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
