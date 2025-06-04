<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\StoreParameterSetting;

class StoreParameterSettingCommand
{
    /**
     * @var string
     */
    private string $startDate;

    /**
     * @var string
     */
    private string $endDate;

    /**
     * @var int
     */
    private int $type;

    /**
     * @var int
     */
    private int $parameter;

    /**
     * @var array
     */
    private array $acrissIds;

    /**
     * @var array|null
     */
    private ?array $replacementAcrissIds;

    /**
     * @var array|null
     */
    private ?array $regionIds;

    /**
     * @var array|null
     */
    private ?array $areaIds;

    /**
     * @var array|null
     */
    private ?array $branchIds;

    /**
     * @var array
     */
    private array $partnerIds;

    /**
     * @var string|null
     */
    private ?string $startTime;

    /**
     * @var string|null
     */
    private ?string $endTime;

    /**
     * @var bool
     */
    private bool $connectedVehicle;

    /**
     * @var bool|null
     */
    private ?bool $isOverride;

    public function __construct(
        string $startDate,
        string $endDate,
        int $type,
        int $parameter,
        array $acrissIds,
        ?array $replacementAcrissIds,
        ?array $regionIds,
        ?array $areaIds,
        ?array $branchIds,
        array $partnerIds,
        ?string $startTime,
        ?string $endTime,
        bool $connectedVehicle,
        ?bool $isOverride = null
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->type = $type;
        $this->parameter = $parameter;
        $this->acrissIds = $acrissIds;
        $this->replacementAcrissIds = $replacementAcrissIds;
        $this->regionIds = $regionIds;
        $this->areaIds = $areaIds;
        $this->branchIds = $branchIds;
        $this->partnerIds = $partnerIds;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->connectedVehicle = $connectedVehicle;
        $this->isOverride = $isOverride;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getParameter(): int
    {
        return $this->parameter;
    }

    /**
     * @return array
     */
    public function getAcrissIds(): array
    {
        return $this->acrissIds;
    }

    /**
     * @return array|null
     */
    public function getReplacementAcrissIds(): ?array
    {
        return $this->replacementAcrissIds;
    }

    /**
     * @return array|null
     */
    public function getRegionIds(): ?array
    {
        return $this->regionIds;
    }

    /**
     * @return array|null
     */
    public function getAreaIds(): ?array
    {
        return $this->areaIds;
    }

    /**
     * @return array|null
     */
    public function getBranchIds(): ?array
    {
        return $this->branchIds;
    }

    /**
     * @return array
     */
    public function getPartnerIds(): array
    {
        return $this->partnerIds;
    }

    /**
     * @return string|null
     */
    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    /**
     * @return string|null
     */
    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    /**
     * @return bool
     */
    public function getConnectedVehicle(): bool
    {
        return $this->connectedVehicle;
    }

    /**
     * @return bool|null
     */
    public function getIsOverride(): ?bool
    {
        return $this->isOverride;
    }
}
