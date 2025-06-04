<?php
declare(strict_types=1);

namespace Distribution\Branch\Domain;

use Shared\Domain\Criteria\Criteria;

class BranchCriteria extends Criteria
{

    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [
            'countryId',
            'regionId',
            'areaId',
            'id',
            'name',
            'state',
            'idOrganizationZone',
            'branchGroupId'
        ];
    }
}