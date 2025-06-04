<?php
declare(strict_types=1);

namespace Distribution\Department\Domain;

use Shared\Domain\Criteria\Criteria;

class DepartmentCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [

        ];
    }
}