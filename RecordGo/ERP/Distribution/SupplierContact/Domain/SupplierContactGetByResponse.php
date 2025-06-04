<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class SupplierGetByResponse
 * @method SupplierContactCollection getCollection()
 */

class SupplierContactGetByResponse extends GetByResponse
{
    /**
     * SupplierContactGetByResponse constructor.
     * @param SupplierContactCollection $collection
     * @param int $totalRows
     */
    public function __construct(SupplierContactCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}