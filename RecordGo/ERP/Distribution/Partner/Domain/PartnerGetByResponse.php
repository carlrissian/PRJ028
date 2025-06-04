<?php

declare(strict_types=1);

namespace Distribution\Partner\Domain;

use Shared\Domain\GetByResponse;

class PartnerGetByResponse extends GetByResponse
{
    /**
     * PartnerGetByResponse constructor.
     * 
     * @param PartnerCollection $collection
     * @param int $totalRows
     */
    public function __construct(PartnerCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
