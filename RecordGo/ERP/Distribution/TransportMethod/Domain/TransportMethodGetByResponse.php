<?php
declare(strict_types=1);

namespace Distribution\TransportMethod\Domain;

use Shared\Domain\GetByResponse;

/**
 * @method TransportMethodCollection getCollection()
 */
class TransportMethodGetByResponse extends GetByResponse
{
    /**
     * TransportMethodGetByResponse constructor.
     * @param TransportMethodCollection $collection
     * @param int $totalRows
     */
    public function __construct(TransportMethodCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}