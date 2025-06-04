<?php
declare(strict_types=1);


namespace Distribution\Planning\Application\FilterPlanning;


class FilterPlanningResponse
{
    /**
     * @var array
     */
    private array $planning;

    /**
     * FilterPlanningResponse constructor.
     * @param array $planning
     */
    public function __construct(array $planning)
    {
        $this->planning = $planning;
    }

    /**
     * @return array
     */
    public function getPlanning(): array
    {
        return $this->planning;
    }


}