<?php

namespace Distribution\Damage\Domain;

interface DamageRepository
{
    /**
     *
     * @param DamageCriteria $criteria
     * @return DamageGetByResponse
     */
    public function getBy(DamageCriteria $criteria): DamageGetByResponse;
}
