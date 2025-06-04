<?php
declare(strict_types=1);


namespace Distribution\Route\Domain;


use Shared\Domain\Criteria\Criteria;

class RouteCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
            'supplierCode',
            'checkOutLocationId',
            'checkInLocationId',
            'countryCode',
            'units'
        ];
    }
}