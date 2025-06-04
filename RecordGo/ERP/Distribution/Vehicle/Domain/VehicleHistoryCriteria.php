<?php
declare(strict_types=1);


namespace Distribution\Vehicle\Domain;


use Shared\Domain\Criteria\Criteria;

class VehicleHistoryCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
            'vehicleId',
            'status',
            'locationId',
        ];
    }
}