<?php
declare(strict_types=1);

namespace Distribution\Brand\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class BrandGetByResponse
 * @method BrandCollection getCollection()
 */
class BrandGetByResponse extends GetByResponse
{
    /**
     * CarGroupGetByResponse constructor.
     * @param BrandCollection $collection
     * @param int $totalRows
     */
    public function __construct(BrandCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}