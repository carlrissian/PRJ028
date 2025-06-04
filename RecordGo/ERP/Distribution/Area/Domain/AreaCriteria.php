<?php
declare(strict_types=1);


namespace Distribution\Area\Domain;


use Shared\Domain\Criteria\Criteria;

class AreaCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return[
            'countryId',
            'regionId',
            'areaId',
            'name'
        ];
    }
}