<?php
declare(strict_types=1);


namespace Distribution\MovementCategory\Domain;


use Shared\Domain\Criteria\Criteria;

class MovementCategoryCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
        ];
    }
}