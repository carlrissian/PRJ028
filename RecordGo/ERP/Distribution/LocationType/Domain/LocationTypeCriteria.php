<?php
declare(strict_types=1);


namespace Distribution\LocationType\Domain;


use Shared\Domain\Criteria\Criteria;

class LocationTypeCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
        ];
    }
}