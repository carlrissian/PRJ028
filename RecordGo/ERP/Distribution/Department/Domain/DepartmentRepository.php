<?php

declare(strict_types=1);

namespace Distribution\Department\Domain;

interface DepartmentRepository
{
    /**
     * @param DepartmentCriteria $criteria
     * @return DepartmentGetByResponse
     */
    public function getBy(DepartmentCriteria $criteria): DepartmentGetByResponse;


    /**
     * @param int $id
     * @return Department|null
     */
    public function getById(int $id): ?Department;
}
