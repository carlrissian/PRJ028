<?php
declare(strict_types=1);

namespace Distribution\CommercialGroup\Domain;

use Shared\Domain\Criteria\Criteria;

class CommercialGroupCriteria extends Criteria
{

    /**
     * @inheritDoc
     */
    public function getAllowedFields(): array
    {
        return [
            'id',
            'name',
            'acrissId'
        ];
    }
}
