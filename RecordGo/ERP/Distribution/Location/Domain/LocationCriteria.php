<?php
declare(strict_types=1);


namespace Distribution\Location\Domain;


use Shared\Domain\Criteria\Criteria;

class LocationCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return[
            'locationType',
            'branchId',
            'branchGroupId'
        ];
    }
}