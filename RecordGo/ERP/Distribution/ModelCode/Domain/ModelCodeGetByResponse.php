<?php
declare(strict_types=1);

namespace Distribution\ModelCode\Domain;

use Shared\Domain\GetByResponse;

class ModelCodeGetByResponse extends GetByResponse
{
    /**
     * ModelCodeGetByResponse constructor.
     * @param ModelCodeCollection $collection
     * @param int $totalRows
     */
    public function __construct(ModelCodeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}