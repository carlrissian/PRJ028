<?php

namespace Distribution\InsurancePolicies\Domain;

use Shared\Domain\Collection;

class InsurancePoliciesCollection extends Collection
{
    protected function type(): string
    {
        return InsurancePolicies::class;
    }
}
