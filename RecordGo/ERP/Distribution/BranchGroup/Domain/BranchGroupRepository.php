<?php

declare(strict_types=1);

namespace Distribution\BranchGroup\Domain;

interface BranchGroupRepository
{
    /**
     * @param BranchGroupCriteria $criteria
     * @return BranchGroupGetByResponse
     */
    public function getBy(BranchGroupCriteria $criteria): BranchGroupGetByResponse;

    /**
     * @param integer $id
     * @return BranchGroup|null
     */
    public function getById(int $id): ?BranchGroup;
}
