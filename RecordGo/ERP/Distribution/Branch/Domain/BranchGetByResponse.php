<?php
declare(strict_types=1);

namespace Distribution\Branch\Domain;

use Shared\Domain\GetByResponse;

/**
 * @method BranchCollection getCollection()
 */
class BranchGetByResponse extends GetByResponse
{
    /**
     * BranchResponse constructor.
     * @param BranchCollection $collection
     * @param int $totalRows
     */
    public function __construct(BranchCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}