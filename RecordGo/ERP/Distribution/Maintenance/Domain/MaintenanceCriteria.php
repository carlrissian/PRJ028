<?php
declare(strict_types=1);


namespace Distribution\Maintenance\Domain;


use Shared\Domain\Criteria\Criteria;

class MaintenanceCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
            'documentId',
        ];
    }
}