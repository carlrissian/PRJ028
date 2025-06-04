<?php
declare(strict_types=1);


namespace Distribution\Supplier\Domain;


use Shared\Domain\GetByResponse;
/**
 * Class SupplierGetByResponse
 * @method SupplierCollection getCollection()
 */
class SupplierGetByResponse extends GetByResponse
{
    /**
     * SupplierGetByResponse constructor.
     * @param SupplierCollection $collection
     * @param int $totalRows
     */
    public function __construct(SupplierCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}