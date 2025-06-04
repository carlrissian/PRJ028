<?php

namespace Distribution\Product\Domain;

use Shared\Domain\Criteria\Criteria;

class ProductCriteria extends Criteria
{
    /**
     * @inheritDoc
     */
    public function getAllowedFields(): array
    {
        return [
            'CODENAME',
            'PRODUCTNINTREF',
            'REFUELPOLICYID',
            'KMPOLICYID',
            'MODIFICATIONPOLICYID'
        ];
    }
}
