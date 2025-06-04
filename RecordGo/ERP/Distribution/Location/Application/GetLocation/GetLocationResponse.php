<?php
declare(strict_types=1);


namespace Distribution\Location\Application\GetLocation;

use Distribution\Location\Domain\LocationCollection;
use Shared\Domain\GetByResponse;

class GetLocationResponse extends GetByResponse
{
    public function __construct(LocationCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}