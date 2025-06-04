<?php
declare(strict_types=1);

namespace Distribution\CommercialGroup\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class CommercialGroupGetByResponse
 * @method CommercialGroupGetByResponse
 */
class CommercialGroupGetByResponse extends GetByResponse
{
    /**
     * CommercialGroupGetByResponse constructor.
     * @param CommercialGroupCollection $collection
     * @param int $totalRows
     */
    public function __construct(CommercialGroupCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
