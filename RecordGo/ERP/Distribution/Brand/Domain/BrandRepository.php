<?php

declare(strict_types=1);

namespace Distribution\Brand\Domain;

interface BrandRepository
{
    /**
     * @param BrandCriteria $brandCriteria
     * @return BrandGetByResponse
     */
    public function getBy(BrandCriteria $brandCriteria): BrandGetByResponse;

    /**
     * @param integer $id
     * @return Brand|null
     */
    public function getById(int $id): ?Brand;
}
