<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\Criteria\Criteria;

class MovementCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return[
            'id',
            'movementTypeId',
            'orderNumber',
            'licensePlate',
            'vin',
            'brandId',
            'modelId',
            'supplierCode',
            'originLocationId',
            'destinationLocationId',
            'destinationLocationId',
            'businessUnitId',
            'businessUnitArticleId',
            'expectedLoadDate',
            'expectedUnloadDate',
            'actualLoadDate',
            'actualUnloadDate',
            'movementStatusId',
            'originBranchId',
            'destinationBranchId',
            'extTransport',
            'movementCategory',
        ];
    }
}