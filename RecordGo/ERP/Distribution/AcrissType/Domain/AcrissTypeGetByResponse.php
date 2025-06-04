<?php
declare(strict_types=1);


namespace Distribution\AcrissType\Domain;


use Shared\Domain\GetByResponse;

class AcrissTypeGetByResponse extends GetByResponse
{
    /**
     * AcrissSecondLetterGetSecondLetterResponse constructor.
     * @param AcrissTypeCollection $collection
     * @param int $totalRows
     */
    public function __construct(AcrissTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}