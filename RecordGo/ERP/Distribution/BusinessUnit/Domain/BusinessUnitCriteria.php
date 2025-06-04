<?php
declare(strict_types=1);


namespace Distribution\BusinessUnit\Domain;


use Shared\Domain\Criteria\Criteria;

class BusinessUnitCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
        ];
    }
}