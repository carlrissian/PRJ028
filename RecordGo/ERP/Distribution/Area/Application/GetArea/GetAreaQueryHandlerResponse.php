<?php
declare(strict_types=1);


namespace Distribution\Area\Application\GetArea;


use Distribution\Area\Domain\AreaCollection;
use Shared\Domain\GetByResponse;

class GetAreaQueryHandlerResponse extends GetByResponse
{
    public function __construct(AreaCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}