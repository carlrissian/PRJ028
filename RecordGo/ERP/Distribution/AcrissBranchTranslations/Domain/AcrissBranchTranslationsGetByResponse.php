<?php

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Domain\GetByResponse;

final class AcrissBranchTranslationsGetByResponse extends GetByResponse
{
    /**
     * AcrissBranchTranslationsGetByResponse constructor.
     * @param AcrissBranchTranslationCollection $collection
     * @param int $totalRows
     */
    public function __construct(AcrissBranchTranslationCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
