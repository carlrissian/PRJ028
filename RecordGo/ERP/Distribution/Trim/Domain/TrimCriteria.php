<?php
declare(strict_types=1);


namespace Distribution\Trim\Domain;


use Shared\Domain\Criteria\Criteria;

class TrimCriteria extends Criteria
{

    /**
     * @inheritDoc
     */
    public function getAllowedFields(): array
    {
        return [
        ];
    }
}