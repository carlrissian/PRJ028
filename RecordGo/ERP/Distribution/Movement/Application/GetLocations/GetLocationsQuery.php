<?php
declare(strict_types=1);


namespace Distribution\Movement\Application\GetLocations;


class GetLocationsQuery
{
    /**
     * @var array|null
     */
    private ?array $typeLocationArray;
    /**
     * @var int|null
     */
    private ?int $branchId;

    /**
     * @param array|null $typeLocationArray
     * @param int|null $branchId
     */
    public function __construct(?array $typeLocationArray, ?int $branchId)
    {
        $this->typeLocationArray = $typeLocationArray;
        $this->branchId = $branchId;
    }

    /**
     * @return array|null
     */
    public function getTypeLocationArray(): ?array
    {
        return $this->typeLocationArray;
    }

    /**
     * @return int|null
     */
    public function getBranchId(): ?int
    {
        return $this->branchId;
    }


}