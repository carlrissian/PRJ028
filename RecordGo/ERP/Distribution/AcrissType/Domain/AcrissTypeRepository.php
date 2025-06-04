<?php
declare(strict_types=1);

namespace Distribution\AcrissType\Domain;

interface AcrissTypeRepository
{
    /**
     * @return AcrissTypeGetByResponse
     */
    public function getBy(AcrissTypeCriteria $criteria): ?AcrissTypeGetByResponse;

    public function getById(int $id): ?AcrissType;

}
