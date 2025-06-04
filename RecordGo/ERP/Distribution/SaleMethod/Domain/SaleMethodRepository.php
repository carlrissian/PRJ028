<?php

declare(strict_types=1);

namespace Distribution\SaleMethod\Domain;

interface SaleMethodRepository
{
    /**
     * @param SaleMethodCriteria $criteria
     * @return SaleMethodGetByResponse
     */
    public function getBy(SaleMethodCriteria $criteria): SaleMethodGetByResponse;
}
