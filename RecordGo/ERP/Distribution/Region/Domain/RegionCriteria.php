<?php
declare(strict_types=1);


namespace Distribution\Region\Domain;


use Shared\Domain\Criteria\Criteria;

class RegionCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
            'countryId',
            'regionId',
        ];
    }
}