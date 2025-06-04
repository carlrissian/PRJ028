<?php
declare(strict_types=1);


namespace Distribution\Location\Application\Shared;

use Shared\Domain\Collection;
use Shared\Domain\GetByResponse;

class AbstractLocationResponse extends GetByResponse
{
    public function __construct(Collection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}