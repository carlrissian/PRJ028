<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Domain;

use Shared\Domain\GetByResponse;

class AcrissImageLineGetByResponse extends GetByResponse
{
    /**
     * ImageLineGetByResponse constructor.
     * 
     * @param AcrissImageLineCollection $collection
     * @param int $totalRows
     */
    public function __construct(AcrissImageLineCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
