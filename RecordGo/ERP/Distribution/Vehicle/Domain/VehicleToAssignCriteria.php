<?php

namespace Distribution\Vehicle\Domain;

use Shared\Domain\Criteria\Criteria;

class VehicleToAssignCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'movementId',
            'movementTypeId',
        ];
    }
}
