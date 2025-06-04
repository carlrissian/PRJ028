<?php
declare(strict_types=1);


namespace Distribution\ParameterSetting\Domain;


use Shared\Domain\Criteria\Criteria;

class ParameterSettingCriteria extends Criteria
{

    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [
            'acrissId',
            'substitutionAcrissId',
            'regionId',
            'areaId',
            'branchId',
            'connectedVehicle',
            'startDate',
            'endDate',
            'creationDate',
            'creationTime',
            'typeId',
        ];
    }
}