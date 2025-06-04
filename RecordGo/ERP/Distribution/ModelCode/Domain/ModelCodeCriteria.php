<?php
declare(strict_types=1);

namespace Distribution\ModelCode\Domain;

use Shared\Domain\Criteria\Criteria;
class ModelCodeCriteria extends Criteria
{
    final public function getAllowedFields(): array
    {
        return [
            'id',
            'name'
        ];
    }
}