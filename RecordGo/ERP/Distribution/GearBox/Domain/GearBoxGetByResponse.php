<?php
declare(strict_types=1);

namespace Distribution\GearBox\Domain;

use Shared\Domain\GetByResponse;

/**
 * @method GearBoxCollection getCollection()
 */
class GearBoxGetByResponse extends GetByResponse
{
    /**
     * GearBoxGetByResponse constructor.
     * @param GearBoxCollection $collection
     * @param int $totalRows
     */
    public function __construct(GearBoxCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}