<?php
declare(strict_types=1);


namespace Distribution\StopSaleType\Domain;


use Shared\Domain\Criteria\Criteria;

class StopSaleTypeCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
            'id',
            'name'
        ];
    }
}