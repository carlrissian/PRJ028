<?php

declare(strict_types=1);

namespace Distribution\PurchaseMethod\Domain;

use Shared\Domain\GetByResponse;

class PurchaseMethodGetByResponse extends GetByResponse
{
    /**
     * PurchaseMethodGetByResponse constructor.
     * 
     * @param PurchaseMethodCollection $collection
     * @param int $totalRows
     */
    public function __construct(PurchaseMethodCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
