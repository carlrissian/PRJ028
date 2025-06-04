<?php

declare(strict_types=1);

namespace Distribution\State\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class StateGetByResponse
 * @method StateCollection getCollection()
 */
class StateGetByResponse extends GetByResponse
{
    /**
     * StateGetByResponse constructor.
     * @param StateCollection $collection
     * @param int $totalRows
     */
    public function __construct(StateCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
