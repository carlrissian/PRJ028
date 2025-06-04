<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\GetByResponse;

/**
 * Class CheckVehicleGetByResponse
 * @method CheckVehicleCollection getCollection()
 */
class CheckVehicleGetByResponse  extends GetByResponse
{
    public function __construct(CheckVehicleCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}