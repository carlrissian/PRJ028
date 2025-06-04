<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;

class PlanningLine
{
    /**
     * @var int|null
     */
    private ?int $fleetPlanId;
    /**
     * @var string|null
     */
    private ?string $modelCode;
    /**
     * @var AssignedVehicleCollection|null
     */
    private ?AssignedVehicleCollection $assignedVehicleCollection;
    /**
     * @var bool|null
     */
    private ?bool $validated;
    /**
     * @var Brand|null
     */
    private ?Brand $brand;
    /**
     * @var Model|null
     */
    private ?Model $model;
    /**
     * @var PurchaseMethod|null
     */
    private ?PurchaseMethod $purchaseMethod;
    /**
     * @var PurchaseType|null
     */
    private ?PurchaseType $purchaseType;
    /**
     * @var GearBox|null
     */
    private ?GearBox $gearBox;
    /**
     * @var MotorizationType|null
     */
    private ?MotorizationType $motorizationType;
    /**
     * @var Acriss|null
     */
    private ?Acriss $acriss;
    /**
     * @var CarGroup|null
     */
    private ?CarGroup $carGroup;
    /**
     * @var CommercialGroup|null
     */
    private ?CommercialGroup $commercialGroup;
    /**
     * @var CarClass|null
     */
    private ?CarClass $carClass;
    /**
     * @var bool|null
     */
    private ?bool $connectedVehicle;
    /**
     *  @var int|null
     */
    private ?int $unitsTotal;

    /**
     * PlanningLine constructor.
     * @param int|null $fleetPlanId
     * @param string|null $modelCode
     * @param AssignedVehicleCollection|null $assignedVehicleCollection
     * @param bool|null $validated
     * @param Brand|null $brand
     * @param Model|null $model
     * @param PurchaseMethod|null $purchaseMethod
     * @param PurchaseType|null $purchaseType
     * @param GearBox|null $gearBox
     * @param MotorizationType|null $motorizationType
     * @param Acriss|null $acriss
     * @param CarGroup|null $carGroup
     * @param CommercialGroup|null $commercialGroup
     * @param CarClass|null $carClass
     * @param bool|null $connectedVehicle
     * @param int|null $unitsTotal
     */
    public function __construct(?int $fleetPlanId = null, ?string $modelCode=null, AssignedVehicleCollection $assignedVehicleCollection=null, ?bool $validated = null, ?Brand $brand = null, ?Model $model = null, ?PurchaseMethod $purchaseMethod = null, ?PurchaseType $purchaseType = null, ?GearBox $gearBox = null, ?MotorizationType $motorizationType = null, ?Acriss $acriss = null, ?CarGroup $carGroup = null, ?CommercialGroup $commercialGroup = null, ?CarClass $carClass = null, ?bool $connectedVehicle = null, int $unitsTotal = null)
    {
        $this->fleetPlanId = $fleetPlanId;
        $this->modelCode = $modelCode;
        $this->assignedVehicleCollection = $assignedVehicleCollection;
        $this->validated = $validated;
        $this->brand = $brand;
        $this->model = $model;
        $this->purchaseMethod = $purchaseMethod;
        $this->purchaseType = $purchaseType;
        $this->gearBox = $gearBox;
        $this->motorizationType = $motorizationType;
        $this->acriss = $acriss;
        $this->carGroup = $carGroup;
        $this->commercialGroup = $commercialGroup;
        $this->carClass = $carClass;
        $this->connectedVehicle = $connectedVehicle;
        $this->unitsTotal = $unitsTotal;
    }

    /**
     * @return int|null
     */
    public function getFleetPlanId(): ?int
    {
        return $this->fleetPlanId;
    }

    /**
     * @return string|null
     */
    public function getModelCode(): ?string
    {
        return $this->modelCode;
    }

    /**
     * @return AssignedVehicleCollection
     */
    public function getAssignedVehicleCollection(): AssignedVehicleCollection
    {
        return $this->assignedVehicleCollection;
    }

    /**
     * @return bool|null
     */
    public function getValidated(): ?bool
    {
        return $this->validated;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * @return PurchaseMethod|null
     */
    public function getPurchaseMethod(): ?PurchaseMethod
    {
        return $this->purchaseMethod;
    }

    /**
     * @return PurchaseType|null
     */
    public function getPurchaseType(): ?PurchaseType
    {
        return $this->purchaseType;
    }

    /**
     * @return GearBox|null
     */
    public function getGearBox(): ?GearBox
    {
        return $this->gearBox;
    }

    /**
     * @return MotorizationType|null
     */
    public function getMotorizationType(): ?MotorizationType
    {
        return $this->motorizationType;
    }

    /**
     * @return Acriss|null
     */
    public function getAcriss(): ?Acriss
    {
        return $this->acriss;
    }

    /**
     * @return CarGroup|null
     */
    public function getCarGroup(): ?CarGroup
    {
        return $this->carGroup;
    }

    /**
     * @return CommercialGroup|null
     */
    public function getCommercialGroup(): ?CommercialGroup
    {
        return $this->commercialGroup;
    }

    /**
     * @return CarClass|null
     */
    public function getCarClass(): ?CarClass
    {
        return $this->carClass;
    }

    /**
     * @return bool|null
     */
    public function getConnectedVehicle(): ?bool
    {
        return $this->connectedVehicle;
    }
    /**
     * @return int
     */
    public function getUnitsTotal(): int
    {
        return $this->unitsTotal;
    }

}
