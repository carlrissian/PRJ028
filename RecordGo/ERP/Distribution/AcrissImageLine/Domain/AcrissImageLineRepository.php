<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Domain;

interface AcrissImageLineRepository
{
    /**
     * @param AcrissImageLineCriteria $criteria
     * @return AcrissImageLineGetByResponse
     */
    // public function getBy(AcrissImageLineCriteria $criteria): AcrissImageLineGetByResponse;

    /**
     * @param AcrissImageLine $acrissImageLine
     * @return int
     */
    public function store(AcrissImageLine $acrissImageLine): int;

    /**
     * @param AcrissImageLine $acrissImageLine
     * @return int
     */
    public function update(AcrissImageLine $acrissImageLine): int;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
