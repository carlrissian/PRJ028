<?php

declare(strict_types=1);

namespace Distribution\BranchGroup\Domain;

use Shared\Domain\GetByResponse;

/**
 * @method BranchGroupCollection getCollection()
 */
class BranchGroupGetByResponse  extends GetByResponse
{
    /**
     * @param BranchGroupCollection $collection
     * @param int $totalRows
     */
    public function __construct(BranchGroupCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
