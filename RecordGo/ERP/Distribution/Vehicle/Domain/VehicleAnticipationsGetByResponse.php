<?php
declare(strict_types=1);


namespace Distribution\Vehicle\Domain;


use Shared\Domain\GetByResponse;

class VehicleAnticipationsGetByResponse extends GetByResponse
{
    public function __construct(VehicleAnticipationCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}