<?php
declare(strict_types=1);

namespace Distribution\AcrissType\Domain;

use Shared\Domain\Criteria\Criteria;

class AcrissTypeCriteria extends Criteria
{
    /**
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [
            'id'
        ];
    }
}