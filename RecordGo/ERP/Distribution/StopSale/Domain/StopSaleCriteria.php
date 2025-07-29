<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Criteria\Criteria;

final class StopSaleCriteria extends Criteria
{
    /**
     * @inheritDoc
     */
    public function getAllowedFields(): array
    {
        return [];
    }
}
