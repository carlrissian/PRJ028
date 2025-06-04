<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;


use Distribution\Branch\Domain\Branch;

class Delegation
{
    /**
     * @var Branch
     */
    private Branch $branch;
    /**
     *  @var int
     */
    private int $orPlan;

    /**
     * Delegation constructor.
     * @param Branch $branch
     * @param int $orPlan
     */
    public function __construct(Branch $branch, int $orPlan)
    {
        $this->branch = $branch;
        $this->orPlan = $orPlan;
    }

    /**
     * @return Branch
     */
    public function getBranch(): Branch
    {
        return $this->branch;
    }

    /**
     * @return int
     */
    public function getOrPlan(): int
    {
        return $this->orPlan;
    }


}