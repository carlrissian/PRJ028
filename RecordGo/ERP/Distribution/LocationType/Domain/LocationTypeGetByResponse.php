<?php
declare(strict_types=1);


namespace Distribution\LocationType\Domain;


use Shared\Domain\GetByResponse;

/**
 * Class LocationTypeGetByResponse
 * @method LocationTypeCollection getCollection()
 */
class LocationTypeGetByResponse extends GetByResponse
{

    /**
     * LocationTypeGetByResponse constructor.
     * @param LocationTypeCollection $collection
     * @param int $totalRows
     */
    public function __construct(LocationTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}