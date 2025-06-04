<?php
declare(strict_types=1);


namespace Distribution\Model\Application\GetModel;


use Distribution\Model\Domain\ModelCollection;
use Shared\Domain\GetByResponse;

class GetModelQueryHandlerResponse extends GetByResponse
{
    public function __construct(ModelCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}