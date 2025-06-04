<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;


interface PlanningRepository
{
    /**
     * @param PlanningFilterCriteria $criteria
     * @return Planning
     */
    public function getPlanningBy(PlanningFilterCriteria $criteria): Planning;

    public function store(Planning $planning): Planning;
}