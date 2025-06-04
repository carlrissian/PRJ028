<?php
declare(strict_types=1);


namespace Distribution\Region\Domain;


interface RegionRepository
{
    /**
     * @param RegionCriteria $regionCriteria
     * @return RegionGetByResponse
     */
    public function getBy(RegionCriteria $regionCriteria): RegionGetByResponse;
    public function getById(int $id): ?Region;
}