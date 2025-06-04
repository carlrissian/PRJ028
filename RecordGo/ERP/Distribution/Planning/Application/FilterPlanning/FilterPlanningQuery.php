<?php
declare(strict_types=1);


namespace Distribution\Planning\Application\FilterPlanning;


class FilterPlanningQuery
{
    /**
     * @var int
     */
    private int $month;
    /**
     * @var array|null
     */
    private ?array $brandId;
    /**
     * @var array|null
     */
    private ?array $modelId;
    /**
     * @var array|null
     */
    private ?array $purchaseMethodId;
    /**
     * @var array|null
     */
    private ?array $purchaseTypeId;
    /**
     * @var array|null
     */
    private ?array $gearBoxId;
    /**
     * @var array|null
     */
    private ?array $motorizationTypeId;
    /**
     * @var array|null
     */
    private ?array $acrissId;
    /**
     * @var array|null
     */
    private ?array $carGroupId;
    /**
     * @var array|null
     */
    private ?array $commercialGroupId;
    /**
     * @var array|null
     */
    private ?array $carClassId;
    /**
     * @var bool|null
     */
    private ?bool $connectedVehicle;
    /**
     * @var array|null
     */
    private ?array $pendingAssignmentsId;
    /**
     * @var array|null
     */
    private ?array $fleetPlannerStatusId;
    /**
     * @var int|null
     */
    private ?int $year;
    /**
     * @var array|null
     */
    private ?array $vehicleLinesId;
    /**
     * @var array|null
     */
    private ?array $orPlan;

    /**
     * FilterPlanningQuery constructor.
     * @param int $month
     * @param array|null $brandId
     * @param array|null $modelId
     * @param array|null $purchaseMethodId
     * @param array|null $purchaseTypeId
     * @param array|null $gearBoxId
     * @param array|null $motorizationTypeId
     * @param array|null $acrissId
     * @param array|null $carGroupId
     * @param array|null $carClassId
     * @param bool|null $connectedVehicle
     * @param array|null $pendingAssignmentsId
     * @param array|null $fleetPlannerStatusId
     * @param int|null $year
     * @param array|null $commercialGroupId
     * @param array|null $vehicleLinesId
     * @param array|null $orPlan
     */
    public function __construct(int $month, ?array $brandId, ?array $modelId, ?array $purchaseMethodId, ?array $purchaseTypeId, ?array $gearBoxId, ?array $motorizationTypeId, ?array $acrissId, ?array $carGroupId,?array $commercialGroupId, ?array $carClassId, ?bool $connectedVehicle, ?array $pendingAssignmentsId, ?array $fleetPlannerStatusId, ?int $year, ?array $vehicleLinesId = null, ?array $orPlan = null )
    {
        $this->month = $month;
        $this->brandId = $brandId;
        $this->modelId = $modelId;
        $this->purchaseMethodId = $purchaseMethodId;
        $this->purchaseTypeId = $purchaseTypeId;
        $this->gearBoxId = $gearBoxId;
        $this->motorizationTypeId = $motorizationTypeId;
        $this->acrissId = $acrissId;
        $this->carGroupId = $carGroupId;
        $this->commercialGroupId = $commercialGroupId;
        $this->carClassId = $carClassId;
        $this->connectedVehicle = $connectedVehicle;
        $this->pendingAssignmentsId = $pendingAssignmentsId;
        $this->fleetPlannerStatusId = $fleetPlannerStatusId;
        $this->year = $year;
        $this->vehicleLinesId = $vehicleLinesId;
        $this->orPlan = $orPlan;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return array|null
     */
    public function getBrandId(): ?array
    {
        return $this->brandId;
    }

    /**
     * @return array|null
     */
    public function getModelId(): ?array
    {
        return $this->modelId;
    }

    /**
     * @return array|null
     */
    public function getPurchaseMethodId(): ?array
    {
        return $this->purchaseMethodId;
    }

    /**
     * @return array|null
     */
    public function getPurchaseTypeId(): ?array
    {
        return $this->purchaseTypeId;
    }

    /**
     * @return array|null
     */
    public function getGearBoxId(): ?array
    {
        return $this->gearBoxId;
    }

    /**
     * @return array|null
     */
    public function getMotorizationTypeId(): ?array
    {
        return $this->motorizationTypeId;
    }

    /**
     * @return array|null
     */
    public function getAcrissId(): ?array
    {
        return $this->acrissId;
    }

    /**
     * @return array|null
     */
    public function getCarGroupId(): ?array
    {
        return $this->carGroupId;
    }

    /**
     * @return array|null
     */
    public function getCarClassId(): ?array
    {
        return $this->carClassId;
    }

    /**
     * @return bool|null
     */
    public function getConnectedVehicle(): ?bool
    {
        return $this->connectedVehicle;
    }

    /**
     * @return array|null
     */
    public function getPendingAssignmentsId(): ?array
    {
        return $this->pendingAssignmentsId;
    }

    /**
     * @return array|null
     */
    public function getFleetPlannerStatusId(): ?array
    {
        return $this->fleetPlannerStatusId;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @return array|null
     */
    public function getCommercialGroupId(): ?array
    {
        return $this->commercialGroupId;
    }

    /**
     * @return array|null
     */
    public function getVehicleLinesId(): ?array
    {
        return $this->vehicleLinesId;
    }

    /**
     * @return array|null
     */
    public function getOrPlan(): ?array
    {
        return $this->orPlan;
    }
}
