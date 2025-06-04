<?php
declare(strict_types=1);


namespace Distribution\PurchaseType\Domain;


use Shared\Domain\GetByResponse;

class PurchaseTypeGetByResponse extends GetByResponse
{
    /**
     * PurchaseTypeGetByResponse constructor.
     * @param PurchaseTypeCollection $collection
     * @param int $totalRows
     */
    public function __construct(PurchaseTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}