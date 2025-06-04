<?php

namespace Distribution\TransportDriver\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class TransportDriverGetByResponse
 * @method TransportDriverGetByResponse getCollection()
 */
class TransportDriverGetByResponse extends GetByResponse
{
    /**
     * TransportDriverGetByResponse constructor.
     * @param TransportDriverCollection $collection
     * @param int $totalRows
     */
    public function __construct(TransportDriverCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
