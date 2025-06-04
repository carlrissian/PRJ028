<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Domain\GetByResponse;

class AcrissBranchTranslationsGetByResponse extends GetByResponse
{
    /**
     * ImageLineGetByResponse constructor.
     * @param AcrissBranchTranslationCollection $collection
     * @param int $totalRows
     */
    public function __construct(AcrissBranchTranslationCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
