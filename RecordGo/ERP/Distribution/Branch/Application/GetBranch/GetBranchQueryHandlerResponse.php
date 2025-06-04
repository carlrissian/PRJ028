<?php
declare(strict_types=1);


namespace Distribution\Branch\Application\GetBranch;


use Distribution\Branch\Domain\BranchCollection;
use Shared\Domain\GetByResponse;

class GetBranchQueryHandlerResponse extends GetByResponse
{
    public function __construct(BranchCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}