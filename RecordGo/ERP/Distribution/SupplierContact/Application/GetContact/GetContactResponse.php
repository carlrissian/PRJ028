<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Application\GetContact;

use Distribution\SupplierContact\Domain\SupplierContactCollection;
use Shared\Domain\GetByResponse;

class GetContactResponse extends GetByResponse
{
    public function __construct(SupplierContactCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}