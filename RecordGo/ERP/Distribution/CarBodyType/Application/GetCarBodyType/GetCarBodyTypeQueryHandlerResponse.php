<?php
declare(strict_types=1);


namespace Distribution\CarBodyType\Application\GetCarBodyType;


use Distribution\CarBodyType\Domain\CarBodyTypeCollection;
use Shared\Domain\GetByResponse;

class GetCarBodyTypeQueryHandlerResponse extends GetByResponse
{
    public function __construct(CarBodyTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}