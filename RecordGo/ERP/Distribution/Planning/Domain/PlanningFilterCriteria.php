<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;


use Shared\Domain\Criteria\Criteria;

class PlanningFilterCriteria  extends Criteria
{
    public function getAllowedFields(): array
    {
        return[
            'month',
            'brandId',
            'modelId',
            'purchaseMethodId',
            'purchaseTypeId',
            'gearBoxId',
            'motorizationTypeId',
            'acrissId',
            'carGroupId',
            'carClassId',
            'commercialGroupId',
            'connectedVehicleId',
            'pendingAssignment',
            'validated',
            'year'
        ];
    }
}
