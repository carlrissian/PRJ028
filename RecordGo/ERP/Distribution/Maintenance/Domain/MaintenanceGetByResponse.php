<?php
declare(strict_types=1);


namespace Distribution\Maintenance\Domain;


use Shared\Domain\GetByResponse;
/**
 * Class RegionGetByResponse
 * @method MaintenanceCollection getCollection()
 */
class MaintenanceGetByResponse extends GetByResponse
{
    /**
     * RegionGetByResponse constructor.
     * @param MaintenanceCollection $collection
     * @param int $totalRows
     */
    public function __construct(MaintenanceCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}