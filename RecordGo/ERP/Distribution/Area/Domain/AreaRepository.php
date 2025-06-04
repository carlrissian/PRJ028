<?php

declare(strict_types=1);

namespace Distribution\Area\Domain;

interface AreaRepository
{
    /**
     * @param AreaCriteria $criteria
     * @return AreaGetByResponse
     */
    public function getBy(AreaCriteria $criteria): AreaGetByResponse;

    /**
     * @param integer $id
     * @return Area|null
     */
    public function getById(int $id): ?Area;
}
