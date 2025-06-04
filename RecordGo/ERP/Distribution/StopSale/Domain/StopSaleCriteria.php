<?php
declare(strict_types=1);

namespace Distribution\StopSale\Domain;

use Shared\Domain\Criteria\Criteria;

class StopSaleCriteria extends Criteria
{

    /**
     * @inheritDoc
     */
    public function getAllowedFields(): array
    {
        return [
            'regionPickId',
            'areaPickId',
            'branchPickId',
            'regionDropId',
            'areaDropId',
            'branchDropId',

            'acrissId',
            'partnerId',
            'connectedVehicle',
            'creationDate',
            'stopSaleTypeId',
            'stopSaleCategoryId',
            'stopSaleInitDate',
            'stopSaleEndDate',
            'stopSaleStatusId',
        ];
    }
}