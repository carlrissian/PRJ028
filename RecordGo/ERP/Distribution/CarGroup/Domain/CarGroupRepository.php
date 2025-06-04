<?php

declare(strict_types=1);

namespace Distribution\CarGroup\Domain;

/**
 * Interface CarGroupRepository
 * @package Distribution\CarGroup\Domain
 */
interface CarGroupRepository
{
    /**
     * @param CarGroupCriteria $groupCriteria
     * @return CarGroupGetByResponse
     */
    public function getBy(CarGroupCriteria $groupCriteria): CarGroupGetByResponse;

    /**
     * @param int $id
     * @return CarGroup|null
     */
    public function getById(int $id): ?CarGroup;

    /**
     * @param CarGroup $carGroup
     * @return int
     */
    public function store(CarGroup $carGroup): int;

    /**
     * @param CarGroup $carGroup
     * @return int
     */
    public function update(CarGroup $carGroup): int;
}
