<?php
declare(strict_types=1);

namespace Distribution\Movement\Application\GetDestinations;

class GetDestinationsQuery
{
    /**
     * @var array|null
     */
    private ?array $locationTypeId;
    /**
     * @var int|null
     */
    private ?int $originId;
    /**
     * @var int|null
     */
    private ?int $branchGroupId;

    /**
     * @param array|null $locationTypeId
     * @param int|null $originId
     * @param int|null $branchGroupId
     */
    public function __construct(?array $locationTypeId, ?int $originId, ?int $branchGroupId)
    {
        $this->locationTypeId = $locationTypeId;
        $this->originId = $originId;
        $this->branchGroupId = $branchGroupId;
    }

    /**
     * @return array|null
     */
    public function getLocationTypeId(): ?array
    {
        return $this->locationTypeId;
    }

    /**
     * @return int|null
     */
    public function getOriginId(): ?int
    {
        return $this->originId;
    }

    /**
     * @return int|null
     */
    public function getBranchGroupId(): ?int
    {
        return $this->branchGroupId;
    }


}
