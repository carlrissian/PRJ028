<?php

declare(strict_types=1);

namespace Distribution\Partner\Domain;

interface PartnerRepository
{
    /**
     * @param PartnerCriteria $criteria
     * @return PartnerGetByResponse
     */
    public function getBy(PartnerCriteria $criteria): PartnerGetByResponse;
}
