<?php

declare(strict_types=1);

namespace Distribution\PurchaseMethod\Domain;

use Shared\Domain\Criteria\Criteria;

class PurchaseMethodCriteria extends Criteria
{
    /**
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [
            'id',
            'name'
        ];
    }
}
