<?php
declare(strict_types=1);

namespace Distribution\Area\Domain;

use Shared\Domain\GetByResponse;

/**
 * @method AreaCollection getCollection()
 */
class AreaGetByResponse extends GetByResponse
{
    /**
     * AreaResponse constructor.
     * @param AreaCollection $collection
     * @param int $totalRows
     */
    public function __construct(AreaCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}