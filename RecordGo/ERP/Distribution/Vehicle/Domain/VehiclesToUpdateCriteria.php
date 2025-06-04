<?php

namespace Distribution\Vehicle\Domain;

use Shared\Domain\Criteria\Criteria;

class VehiclesToUpdateCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'licensePlateIn',
            'vinIn'
        ];
    }
}
