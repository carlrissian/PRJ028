<?php
declare(strict_types=1);


namespace Distribution\BusinessUnit\Domain;


interface BusinessUnitRepository
{
    /**
     * @param BusinessUnitCriteria $criteria
     * @return BusinessUnitGetByResponse
     */
    public function getBy(BusinessUnitCriteria $criteria): BusinessUnitGetByResponse;
}