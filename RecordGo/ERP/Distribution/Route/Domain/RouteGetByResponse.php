<?php
declare(strict_types=1);


namespace Distribution\Route\Domain;


use Shared\Domain\GetByResponse;

class RouteGetByResponse  extends GetByResponse
{
    /**
     * RouteGetByResponse constructor.
     * @param RouteCollection $collection
     * @param int $totalRows
     */
    public function __construct(RouteCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}