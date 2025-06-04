<?php
declare(strict_types=1);


namespace Distribution\Vehicle\Domain;


use Shared\Domain\Criteria\Criteria;

class VehicleCriteria extends Criteria
{

    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [
            'vin',
            'licensePlate',
            'regionId',
            'areaId',
            'branchId',
            'locationId',
            'brandId',
            'modelId',
            'trimId',
            'resaleCodeId',
            'carClassId',
            'carGroupId',
            'acrissId',
            'motorizationTypeId',
            'vehicleStatusId',
            'kilometers',
            'rentingEndDate',
            'transmissionId',
            'logisticId',
            'expectedSaleDate',
            'saleDate',
            'registrationDate',
            'actualLoadingDate',
            'vehicleTypeId',
            'checkInDate'
        ];
    }
}