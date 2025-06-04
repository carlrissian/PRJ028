<?php
declare(strict_types=1);

namespace Distribution\Trim\Domain;

use Shared\Domain\GetByResponse;

/**
 * @method TrimCollection getCollection()
 */
class TrimGetByResponse extends GetByResponse
{
    /**
     * TrimGetByResponse constructor.
     * @param TrimCollection $collection
     * @param int $totalRows
     */
    public function __construct(TrimCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}