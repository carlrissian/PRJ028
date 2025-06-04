<?php

namespace Distribution\InsurancePolicies\Domain;

use Shared\Domain\Criteria\Criteria;

class InsurancePoliciesCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'VEHICLEID'
        ];
    }
}
