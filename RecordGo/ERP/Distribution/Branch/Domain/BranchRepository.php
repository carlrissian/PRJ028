<?php

declare(strict_types=1);

namespace Distribution\Branch\Domain;

/**
 * Interface BranchRepository
 * @package Distribution\Branch\Domain
 */
interface BranchRepository
{
    /**
     * @param BranchCriteria $branchCriteria
     * @return BranchGetByResponse
     */
    public function getBy(BranchCriteria $branchCriteria): BranchGetByResponse;

    /**
     * @param integer $id
     * @return Branch|null
     */
    public function getById(int $id): ?Branch;
}
