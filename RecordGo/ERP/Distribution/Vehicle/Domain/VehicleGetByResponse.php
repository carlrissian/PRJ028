<?php
declare(strict_types=1);


namespace Distribution\Vehicle\Domain;


use Shared\Domain\GetByResponse;

/**
 * @method VehicleCollection getCollection()
 */
class VehicleGetByResponse extends GetByResponse
{
    /**
     * VehicleGetByResponse constructor.
     * @param VehicleCollection $collection
     * @param int $totalRows
     */
    public function __construct(VehicleCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}