<?php
declare(strict_types=1);


namespace Distribution\MovementStatus\Domain;


use Shared\Domain\Criteria\Criteria;

class MovementStatusCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
        ];
    }
}