<?php
declare(strict_types=1);

namespace Distribution\Supplier\Domain;

use Shared\Domain\Criteria\Criteria;

class SupplierCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'code',
            'name',
            'cif',
            'stateId',
            'supplierTypeId'
        ];
    }
}