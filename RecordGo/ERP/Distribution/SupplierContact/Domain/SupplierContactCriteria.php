<?php
declare(strict_types=1);


namespace Distribution\SupplierContact\Domain;


use Shared\Domain\Criteria\Criteria;

class SupplierContactCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'supplierCode',
        ];
    }
}