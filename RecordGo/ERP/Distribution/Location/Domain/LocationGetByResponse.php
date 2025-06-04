<?php
declare(strict_types=1);

namespace Distribution\Location\Domain;

use Shared\Domain\GetByResponse;

/**
 * @method LocationCollection getCollection()
 */
class LocationGetByResponse  extends GetByResponse
{
    /**
     * LocationGetByResponse constructor.
     * @param LocationCollection $collection
     * @param int $totalRows
     */
    public function __construct(LocationCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}