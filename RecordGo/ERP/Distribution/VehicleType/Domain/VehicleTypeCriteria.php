<?php
declare(strict_types=1);


namespace Distribution\VehicleType\Domain;


use Shared\Domain\Criteria\Criteria;

class VehicleTypeCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
            'id',
            'name'
        ];
    }
}