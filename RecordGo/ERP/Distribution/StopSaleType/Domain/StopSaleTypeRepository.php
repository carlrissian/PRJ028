<?php

declare(strict_types=1);

namespace Distribution\StopSaleType\Domain;

interface StopSaleTypeRepository
{
    /**
     * @param StopSaleTypeCriteria $citeria
     * @return StopSaleTypeGetByResponse
     */
    public function getBy(StopSaleTypeCriteria $criteria): StopSaleTypeGetByResponse;
}
