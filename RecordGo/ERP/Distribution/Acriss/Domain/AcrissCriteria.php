<?php
declare(strict_types=1);

namespace Distribution\Acriss\Domain;

use Shared\Domain\Criteria\Criteria;

class AcrissCriteria extends Criteria
{

    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [
            'name',
            'carClassId',
            'commercialGroupId',
            'typeId',
            'gearBoxId',
            'motorizationId',
            'parentId',
            'carGroupId',
            'enabled'
        ];
    }
}