<?php
declare(strict_types=1);


namespace Distribution\CommercialGroupTranslations\Domain;

use Shared\Domain\GetByResponse;

class TranslationsGetByResponse extends GetByResponse
{
    /**
     * CommercialGroupTranslationsGetByResponse constructor.
     * @param TranslationCollection $collection
     * @param int $totalRows
     */
    public function __construct(TranslationCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}