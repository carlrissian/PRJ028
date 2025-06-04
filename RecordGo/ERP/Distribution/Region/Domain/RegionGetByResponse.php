<?php
declare(strict_types=1);


namespace Distribution\Region\Domain;


use Shared\Domain\GetByResponse;
/**
 * Class RegionGetByResponse
 * @method RegionCollection getCollection()
 */
class RegionGetByResponse extends GetByResponse
{
    /**
     * RegionGetByResponse constructor.
     * @param RegionCollection $collection
     * @param int $totalRows
     */
    public function __construct(RegionCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}