<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Domain;

interface CommercialGroupRepository
{
    /**
     * @param CommercialGroupCriteria $criteria
     * @return CommercialGroupGetByResponse
     */
    public function getBy(CommercialGroupCriteria $criteria): CommercialGroupGetByResponse;

    /**
     * @param int $id
     * @return CommercialGroup|null
     */
    public function getById(int $id): ?CommercialGroup;

    /**
     * @param CommercialGroup $commercialGroup
     * @return int
     */
    public function store(CommercialGroup $commercialGroup): int;

    /**
     * @param CommercialGroup $commercialGroup
     * @return int
     */
    public function update(CommercialGroup $commercialGroup): int;


    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
