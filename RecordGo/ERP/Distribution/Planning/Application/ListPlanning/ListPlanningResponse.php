<?php
declare(strict_types=1);


namespace Distribution\Planning\Application\ListPlanning;


class ListPlanningResponse
{

    /**
     * @var array
     */
    private array $brandList;
    /**
     * @var array
     */
    private array $modelList;
    /**
     * @var array
     */
    private array $carGroupList;
    /**
     * @var array
     */
    private array $commercialGroupList;
    /**
     * @var array
     */
    private array $branchList;
    /**
     * @var array
     */
    private array $purchaseMethodList;
    /**
     * @var array
     */
    private array $purchaseTypeList;
    /**
     * @var array
     */
    private array $gearBoxList;
    /**
     * @var array
     */
    private array $motorizationTypeList;
    /**
     * @var array
     */
    private array $acrissList;
    /**
     * @var array
     */
    private array $carClassList;
    /**
     * @var array
     */
    private array $connectedVehicleList;
    /**
     * @var array
     */
    private array $pendingAssignmentsList;
    /**
     * @var array
     */
    private array $fleetPlannerStatusList;
    /**
     * @var array
     */
    private array $monthList;
    /**
     * @var array|null
     */
    private array $acrissTableList;
    /**
     * @var array|null
     */
    private array $carClassTableLIst;
    /**
     * @var array|null
     */
    private array $engineTableList;
    /**
     * @var array|null
     */
    private array $motorizationTableList;
    /**
     * @var array|null
     */
    private array $carGroupTableList;
    /**
     * @var array|null
     */
    private array $commercialGroupTableList;

    /**
     * ListPlanningResponse constructor.
     * @param array $brandList
     * @param array $modelList
     * @param array $carGroupList
     * @param array $commercialGroupList
     * @param array $branchList
     * @param array $purchaseMethodList
     * @param array $purchaseTypeList
     * @param array $gearBoxList
     * @param array $motorizationTypeList
     * @param array $acrissList
     * @param array $carClassList
     * @param array $connectedVehicleList
     * @param array $pendingAssignmentsList
     * @param array $fleetPlannerStatusList
     * @param array $monthList
     */
    public function __construct(array $brandList, array $modelList, array $carGroupList, array $commercialGroupList, array $branchList, array $purchaseMethodList, array $purchaseTypeList, array $gearBoxList, array $motorizationTypeList, array $acrissList, array $carClassList, array $connectedVehicleList, array $pendingAssignmentsList, array $fleetPlannerStatusList, array $monthList)
    {
        $this->brandList = $brandList;
        $this->modelList = $modelList;
        $this->carGroupList = $carGroupList;
        $this->commercialGroupList = $commercialGroupList;
        $this->branchList = $branchList;
        $this->purchaseMethodList = $purchaseMethodList;
        $this->purchaseTypeList = $purchaseTypeList;
        $this->gearBoxList = $gearBoxList;
        $this->motorizationTypeList = $motorizationTypeList;
        $this->acrissList = $acrissList;
        $this->carClassList = $carClassList;
        $this->connectedVehicleList = $connectedVehicleList;
        $this->pendingAssignmentsList = $pendingAssignmentsList;
        $this->fleetPlannerStatusList = $fleetPlannerStatusList;
        $this->monthList = $monthList;
    }

    /**
     * @return array
     */
    public function getBrandList(): array
    {
        return $this->brandList;
    }

    /**
     * @return array
     */
    public function getModelList(): array
    {
        return $this->modelList;
    }

    /**
     * @return array
     */
    public function getCarGroupList(): array
    {
        return $this->carGroupList;
    }

    /**
     * @return array
     */
    public function getCommercialGroupList(): array
    {
        return $this->commercialGroupList;
    }

    /**
     * @return array
     */
    public function getBranchList(): array
    {
        return $this->branchList;
    }

    /**
     * @return array
     */
    public function getPurchaseMethodList(): array
    {
        return $this->purchaseMethodList;
    }

    /**
     * @return array
     */
    public function getPurchaseTypeList(): array
    {
        return $this->purchaseTypeList;
    }

    /**
     * @return array
     */
    public function getGearBoxList(): array
    {
        return $this->gearBoxList;
    }

    /**
     * @return array
     */
    public function getMotorizationTypeList(): array
    {
        return $this->motorizationTypeList;
    }

    /**
     * @return array
     */
    public function getAcrissList(): array
    {
        return $this->acrissList;
    }

    /**
     * @return array
     */
    public function getCarClassList(): array
    {
        return $this->carClassList;
    }

    /**
     * @return array
     */
    public function getConnectedVehicleList(): array
    {
        return $this->connectedVehicleList;
    }

    /**
     * @return array
     */
    public function getPendingAssignmentsList(): array
    {
        return $this->pendingAssignmentsList;
    }

    /**
     * @return array
     */
    public function getFleetPlannerStatusList(): array
    {
        return $this->fleetPlannerStatusList;
    }

    /**
     * @return array
     */
    public function getMonthList(): array
    {
        return $this->monthList;
    }


}
