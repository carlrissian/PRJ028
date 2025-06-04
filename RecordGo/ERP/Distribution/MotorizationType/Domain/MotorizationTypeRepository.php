<?php
declare(strict_types=1);

namespace Distribution\MotorizationType\Domain;


interface MotorizationTypeRepository
{
    /**
     * @param MotorizationTypeCriteria $motorizationTypeCriteria
     * @return MotorizationTypeGetByResponse
     */
    public function getBy(MotorizationTypeCriteria $motorizationTypeCriteria): MotorizationTypeGetByResponse;

    public function getById(int $id): ?MotorizationType;

}
