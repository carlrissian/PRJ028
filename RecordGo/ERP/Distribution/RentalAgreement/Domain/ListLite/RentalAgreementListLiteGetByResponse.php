<?php

namespace Distribution\RentalAgreement\Domain\ListLite;

use Shared\Domain\GetByResponse;

final class RentalAgreementListLiteGetByResponse extends GetByResponse
{
    /**
     * RentalAgreementListLiteGetByResponse constructor.
     * 
     * @param RentalAgreementListLiteCollection $collection
     * @param int $totalRows
     */
    public function __construct(RentalAgreementListLiteCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
