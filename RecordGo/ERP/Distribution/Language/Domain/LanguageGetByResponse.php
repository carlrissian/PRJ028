<?php
declare(strict_types=1);


namespace Distribution\Language\Domain;


use Shared\Domain\GetByResponse;

class LanguageGetByResponse  extends GetByResponse
{
    /**
     * LocationGetByResponse constructor.
     * @param LanguageCollection $collection
     * @param int $totalRows
     */
    public function __construct(LanguageCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}