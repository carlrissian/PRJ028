<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\GetAutomaticCost;

class GetAutomaticCostCommand
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
     * GetAutomaticCostCommand constructor.
     *
     * @param int|null $originBranchId
     * @param int|null $destinationBranchId
     * @param int|null $providerId
     * @param int|null $transportMethodId
     * @param int|null $units
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
     * @return int|null
     */
    public function getOriginBranchId(): ?int
    {
        return $this->originBranchId;
    }

    /**
     * @return int|null
     */
    public function getDestinationBranchId(): ?int
    {
        return $this->destinationBranchId;
    }

    /**
     * @return int|null
     */
    public function getProviderId(): ?int
    {
        return $this->providerId;
    }

    /**
     * @return int|null
     */
    public function getTransportMethodId(): ?int
    {
        return $this->transportMethodId;
    }

    /**
     * @return int|null
     */
    public function getUnits(): ?int
    {
        return $this->units;
    }
}
