<?php

declare(strict_paramaterSettingTypeIds=1);

namespace Distribution\ParameterSetting\Application\FilterParameterSettings;

class FilterParameterSettingsQuery
{
    /**
     * @var int|null
     */
    private ?int $limit;

    /**
     * @var int|null
     */
    private ?int $offset;

    /**
     * @var string|null
     */
    private ?string $order;

    /**
     * @var string|null
     */
    private ?string $sort;

    /**
     * @var array|null
     */
    private ?array $acrissIds;

    /**
     * @var array|null
     */
    private ?array $substitutionAcrissIds;

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
     * @var int|null
     */
    private ?int $paramaterSettingTypeId;

    /**
     * @var bool|null
     */
    private ?bool $connectedVehicle;

    /**
     * @var int|null
     */
    private ?int $countryId;

    /**
     * @var string|null
     */
    private ?string $startDate;

    /**
     * @var string|null
     */
    private ?string $endDate;

    /**
     * @var string|null
     */
    private ?string $creationDateFrom;

    /**
     * @var string|null
     */
    private ?string $creationDateTo;

    /**
     * @var string|null
     */
    private ?string $creationTimeFrom;

    /**
     * @var string|null
     */
    private ?string $creationTimeTo;

    /**
     * FilterParameterSettingsQuery constructor.
     *
     * @param integer|null $limit
     * @param integer|null $offset
     * @param string|null $order
     * @param string|null $sort
     * @param array|null $acrissIds
     * @param array|null $substitutionAcrissIds
     * @param array|null $regionIds
     * @param array|null $areaIds
     * @param array|null $branchIds
     * @param integer|null $paramaterSettingTypeId
     * @param boolean|null $connectedVehicle
     * @param integer|null $countryId
     * @param string|null $startDate
     * @param string|null $endDate
     * @param string|null $creationDateFrom
     * @param string|null $creationDateTo
     * @param string|null $creationTimeFrom
     * @param string|null $creationTimeTo
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $order,
        ?string $sort,
        ?array $acrissIds,
        ?array $substitutionAcrissIds,
        ?array $regionIds,
        ?array $areaIds,
        ?array $branchIds,
        ?int $paramaterSettingTypeId,
        ?bool $connectedVehicle,
        ?int $countryId,
        ?string $startDate,
        ?string $endDate,
        ?string $creationDateFrom,
        ?string $creationDateTo,
        ?string $creationTimeFrom,
        ?string $creationTimeTo
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $this->sort = $sort;
        $this->acrissIds = $acrissIds;
        $this->substitutionAcrissIds = $substitutionAcrissIds;
        $this->regionIds = $regionIds;
        $this->areaIds = $areaIds;
        $this->branchIds = $branchIds;
        $this->paramaterSettingTypeId = $paramaterSettingTypeId;
        $this->connectedVehicle = $connectedVehicle;
        $this->countryId = $countryId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->creationDateFrom = $creationDateFrom;
        $this->creationDateTo = $creationDateTo;
        $this->creationTimeFrom = $creationTimeFrom;
        $this->creationTimeTo = $creationTimeTo;
    }


    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * @return string|null
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @return array|null
     */
    public function getAcrissIds(): ?array
    {
        return $this->acrissIds;
    }

    /**
     * @return array|null
     */
    public function getSubstitutionAcrissIds(): ?array
    {
        return $this->substitutionAcrissIds;
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
     * @return int|null
     */
    public function getParamaterSettingTypeId(): ?int
    {
        return $this->paramaterSettingTypeId;
    }

    /**
     * @return bool|null
     */
    public function getConnectedVehicle(): ?bool
    {
        return $this->connectedVehicle;
    }

    /**
     * @return int|null
     */
    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @return string|null
     */
    public function getCreationDateFrom(): ?string
    {
        return $this->creationDateFrom;
    }

    /**
     * @return string|null
     */
    public function getCreationDateTo(): ?string
    {
        return $this->creationDateTo;
    }

    /**
     * @return string|null
     */
    public function getCreationTimeFrom(): ?string
    {
        return $this->creationTimeFrom;
    }

    /**
     * @return string|null
     */
    public function getCreationTimeTo(): ?string
    {
        return $this->creationTimeTo;
    }
}
