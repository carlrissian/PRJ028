<?php

declare(strict_types=1);

namespace Distribution\SaleMethod\Domain;

use Shared\Domain\Criteria\Criteria;

class SaleMethodCriteria extends Criteria
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
