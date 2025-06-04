<?php
declare(strict_types=1);


namespace Distribution\Department\Domain;

use Shared\Domain\GetByResponse;
/**
 * Class DepartmentGetByResponse
 * @method DepartmentCollection getCollection()
 */
class DepartmentGetByResponse  extends GetByResponse
{
    /**
     * CountryGetByResponse constructor.
     * @param DepartmentCollection $collection
     * @param int $totalRows
     */
    public function __construct(DepartmentCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}