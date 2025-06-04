<?php

declare(strict_types=1);

namespace Distribution\PurchaseMethod\Domain;

interface PurchaseMethodRepository
{
    /**
     * @param PurchaseMethodCriteria $criteria
     * @return PurchaseMethodGetByResponse
     */
    public function getBy(PurchaseMethodCriteria $criteria): PurchaseMethodGetByResponse;
}
