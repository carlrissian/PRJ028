<?php

namespace Distribution\TransportDriver\Domain;

use Shared\Domain\Criteria\Criteria;

class TransportDriverCriteria extends Criteria
{
    /**
     * @inheritDoc
     */
    public function getAllowedFields(): array
    {
        return [
            'id',
            'transportProviderId',
            'rgoUserId',
            'name',
            'lastName',
            'idNumber',
            'driverLicense',
            'issueDate',
            'expiringDate',
            'city',
            'country',
        ];
    }
}
