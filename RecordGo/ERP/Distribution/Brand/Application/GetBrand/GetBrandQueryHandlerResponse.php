<?php
declare(strict_types=1);


namespace Distribution\Brand\Application\GetBrand;


use Distribution\Brand\Domain\BrandCollection;
use Shared\Domain\GetByResponse;

class GetBrandQueryHandlerResponse extends GetByResponse
{
    public function __construct(BrandCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}