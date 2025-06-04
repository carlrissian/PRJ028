<?php
declare(strict_types=1);

namespace Distribution\MotorizationType\Domain;

use Shared\Domain\GetByResponse;

/**
 * @method MotorizationTypeCollection getCollection()
 */
class MotorizationTypeGetByResponse extends GetByResponse
{
    /**
     * MotorizationTypeGetByResponse constructor.
     * @param MotorizationTypeCollection $collection
     * @param int $totalRows
     */
    public function __construct(MotorizationTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}