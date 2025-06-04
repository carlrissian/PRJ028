<?php

declare(strict_types=1);

namespace Distribution\BranchGroup\Domain;

use Shared\Domain\Criteria\Criteria;

class BranchGroupCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
