<?php
declare(strict_types=1);

namespace Distribution\Country\Domain;

use Shared\Domain\Criteria\Criteria;

class CountryCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [

        ];
    }
}