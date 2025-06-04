<?php
declare(strict_types=1);


namespace Distribution\PurchaseType\Domain;

interface PurchaseTypeRepository
{
    /**
     * @param PurchaseTypeCriteria $purchaseTypeCriteria
     * @return PurchaseTypeGetByResponse
     */
    public function getBy(PurchaseTypeCriteria $purchaseTypeCriteria): PurchaseTypeGetByResponse;

}