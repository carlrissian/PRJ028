<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;


use Distribution\Branch\Domain\Branch;

class AssignedVehicle
{
    /**
     * @var Branch
     */
    private Branch $branch;
    /**
     *  @var int|null
     */
    private ?int $unit;
    /**
     * AssignedVehicle constructor.
     * @param Branch $branch
     * @param int|null $unit
     */
    public function __construct(Branch $branch, ?int $unit)
    {
        $this->branch = $branch;
        $this->unit = $unit;
    }

    /**
     * @return Branch
     */
    public function getBranch(): Branch
    {
        return $this->branch;
    }

    /**
     * @return int|null
     */
    public function getUnit(): ?int
    {
        return $this->unit;
    }


}