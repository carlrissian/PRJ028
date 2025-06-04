<?php

namespace Distribution\Route\Domain;

class RouteGetByAutomaticCostRequest
{
    /**
     * @var int|null
     */
    private ?int $originBranchId;
    /**
     * @var int|null
     */
    private ?int $destinationBranchId;
    /**
     * @var int|null
     */
    private ?int $providerId;
    /**
     * @var int|null
     */
    private ?int $transportMethodId;
    /**
     * @var int|null
     */
    private ?int $units;

    /**
     * RouteGetByAutomaticCostRequest constructor.
     *
     * @param integer|null $originBranchId
     * @param integer|null $destinationBranchId
     * @param integer|null $providerId
     * @param integer|null $transportMethodId
     * @param integer|null $units
     */
    public function __construct(
        ?int $originBranchId,
        ?int $destinationBranchId,
        ?int $providerId,
        ?int $transportMethodId,
        ?int $units
    ) {
        $this->originBranchId = $originBranchId;
        $this->destinationBranchId = $destinationBranchId;
        $this->providerId = $providerId;
        $this->transportMethodId = $transportMethodId;
        $this->units = $units;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'BRANCHORIGINID' => $this->originBranchId,
            'BRANCHDESTINYID' => $this->destinationBranchId,
            'TRANSPORTPROVIDERID' => $this->providerId,
            'TRANSPORTMETHODID' => $this->transportMethodId,
            'UNITS' => $this->units,
        ];
    }
}
