<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Domain\GetByResponse;

class VehicleLineGetByResponse extends GetByResponse
{
    /**
     * VehicleLineGetByResponse constructor.
     * 
     * @param VehicleLineCollection $collection
     * @param int $totalRows
     */
    public function __construct(VehicleLineCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
