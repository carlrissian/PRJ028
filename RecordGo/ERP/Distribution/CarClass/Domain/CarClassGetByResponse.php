<?php
declare(strict_types=1);


namespace Distribution\CarClass\Domain;


use Shared\Domain\GetByResponse;

/**
 * Class CarClassGetByResponse
 * @method CarClassCollection getCollection()
 */
class CarClassGetByResponse  extends GetByResponse
{
    /**
     * CarClassGetByResponse constructor.
     * @param CarClassCollection $collection
     * @param int $totalRows
     */
    public function __construct(CarClassCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}