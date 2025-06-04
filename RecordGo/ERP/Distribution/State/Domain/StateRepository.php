<?php

declare(strict_types=1);

namespace Distribution\State\Domain;

interface StateRepository
{
    /**
     * @param StateCriteria $criteria
     * @return StateGetByResponse
     */
    public function getBy(StateCriteria $criteria): StateGetByResponse;

    /**
     * @param integer $id
     * @return State|null
     */
    // public function getById(int $id): ?State;
}
