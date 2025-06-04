<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\GetByResponse;

class ListVehicleGetByResponse  extends GetByResponse
{
    /**
     * ListVehicleGetByResponse constructor.
     * @param MovementVehicleLineCollection $collection
     * @param int $totalRows
     */
    public function __construct(MovementVehicleLineCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}