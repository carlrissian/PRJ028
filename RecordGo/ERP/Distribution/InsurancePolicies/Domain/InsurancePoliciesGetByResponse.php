<?php

namespace Distribution\InsurancePolicies\Domain;

use Shared\Domain\GetByResponse;

class InsurancePoliciesGetByResponse extends GetByResponse
{
    public function __construct(InsurancePoliciesCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
