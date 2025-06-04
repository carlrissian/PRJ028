<?php

namespace Distribution\Vehicle\Domain;

use Shared\Domain\GetByResponse;

class VehicleHistoryGetByResponse extends GetByResponse
{
    /**
     * VehicleHistoryGetByResponse constructor.
     * @param VehicleHistoryCollection $collection
     * @param int $totalRows
     */
    public function __construct(VehicleHistoryCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
