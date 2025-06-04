<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Domain;

use Shared\Domain\GetByResponse;

class AcrissTranslationsGetByResponse extends GetByResponse
{
    /**
     * AcrissTranslationsGetByResponse constructor.
     * 
     * @param AcrissTranslationCollection $collection
     * @param int $totalRows
     */
    public function __construct(AcrissTranslationCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
