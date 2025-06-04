<?php
declare(strict_types=1);

namespace Distribution\Brand\Domain;

use Shared\Domain\Criteria\Criteria;

class BrandCriteria extends Criteria
{

    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * @return array
     */
    public function getAllowedFields(): array
    {
        return[
        ];
    }
}