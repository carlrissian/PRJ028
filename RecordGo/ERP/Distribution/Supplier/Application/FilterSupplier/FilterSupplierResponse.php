<?php

namespace Distribution\Supplier\Application\FilterSupplier;

use Distribution\Supplier\Domain\SupplierCollection;

class FilterSupplierResponse
{
    /**
     * @var SupplierCollection
     */
    private $collection;

    /**
     * @var int
     */
    private $totalRows;

    /**
     * FilterSupplierResponse constructor.
     * 
     * @param SupplierCollection $collection
     * @param int $totalRows
     */
    public function __construct(SupplierCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }

    /**
     * @return SupplierCollection
     */
    public function getCollection(): SupplierCollection
    {
        return $this->collection;
    }

    /**
     * @return int
     */
    public function getTotalRows(): int
    {
        return $this->totalRows;
    }
}
