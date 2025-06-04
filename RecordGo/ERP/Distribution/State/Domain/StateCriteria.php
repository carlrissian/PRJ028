<?php

declare(strict_types=1);

namespace Distribution\State\Domain;

use Shared\Domain\Criteria\Criteria;

class StateCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [];
    }
}
