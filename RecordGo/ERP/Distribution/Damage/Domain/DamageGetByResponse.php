<?php

namespace Distribution\Damage\Domain;

use Shared\Domain\GetByResponse;

class DamageGetByResponse extends GetByResponse
{
    /**
     * DamageGetByResponse constructor.
     * 
     * @param DamageCollection $collection
     * @param int $totalRows
     */
    public function __construct(DamageCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
