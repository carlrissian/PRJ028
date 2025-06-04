<?php
declare(strict_types=1);

namespace Distribution\Planning\Application\FilterPlanning;

use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Branch\Domain\BranchException;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Planning\Domain\PlanningException;
use Distribution\Planning\Domain\PlanningFilterCriteria;
use Distribution\Planning\Domain\PlanningRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;


class FilterPlanningQueryHandler
{
    /**
     * @var PlanningRepository
     */
    private PlanningRepository $planningRepository;
    /**
     * @var BranchRepository
     */
    private BranchRepository $branchRepository;

    /**
     * FilterPlanningQueryHandler constructor.
     * @param PlanningRepository $planningRepository
     * @param BranchRepository $branchRepository
     */
    public function __construct(PlanningRepository $planningRepository, BranchRepository $branchRepository)
    {
        $this->planningRepository = $planningRepository;
        $this->branchRepository = $branchRepository;
    }


    /**
     * @throws PlanningException
     * @throws BranchException
     */
    public function handle(FilterPlanningQuery $query, bool $excel)
    {
        $month = $query->getMonth();
        $year = $query->getYear();
        $brandId = $query->getBrandId();
        $modelId = $query->getModelId();
        $purchaseMethodId = $query->getPurchaseMethodId();
        $purchaseTypeId = $query->getPurchaseTypeId();
        $gearBoxId = $query->getGearBoxId();
        $motorizationTypeId = $query->getMotorizationTypeId();
        $acrissId = $query->getAcrissId();
        $carGroupId = $query->getCarGroupId();
        $commercialGroupId = $query->getCommercialGroupId();
        $carClassId = $query->getCarClassId();
        $connectedVehicleId = $query->getConnectedVehicle();
        $pendingAssignmentsId = $query->getPendingAssignmentsId();
        $fleetPlannerStatusId = $query->getFleetPlannerStatusId();
        [$delegation,$branchIATA]=null;
         $orPlan = [];
        $planningFilterCollection = new FilterCollection([]);
        if(!empty($year)) {
            $planningFilterCollection->add(new Filter('year', new FilterOperator(FilterOperator::EQUAL), $year));
        }
        if(!empty($month)) {
            $planningFilterCollection->add(new Filter('month', new FilterOperator(FilterOperator::EQUAL), $month));
        }
        if (!empty($brandId)) {
            $planningFilterCollection->add(new Filter('brandId', new FilterOperator(FilterOperator::IN), $brandId));
        }
        if (!empty($modelId)) {
            $planningFilterCollection->add(new Filter('modelId', new FilterOperator(FilterOperator::IN), $modelId));
        }
        if (!empty($purchaseMethodId)) {
            $planningFilterCollection->add(new Filter('purchaseMethodId', new FilterOperator(FilterOperator::IN), $purchaseMethodId));
        }
        if (!empty($purchaseTypeId)) {
            $planningFilterCollection->add(new Filter('purchaseTypeId', new FilterOperator(FilterOperator::IN), $purchaseTypeId));
        }
        if (!empty($gearBoxId)) {
            $planningFilterCollection->add(new Filter('gearBoxId', new FilterOperator(FilterOperator::IN), $gearBoxId));
        }
        if (!empty($motorizationTypeId)) {
            $planningFilterCollection->add(new Filter('motorizationTypeId', new FilterOperator(FilterOperator::IN), $motorizationTypeId));
        }
        if (!empty($acrissId)) {
            $planningFilterCollection->add(new Filter('acrissId', new FilterOperator(FilterOperator::IN), $acrissId));
        }
        if (!empty($carGroupId)) {
            $planningFilterCollection->add(new Filter('carGroupId', new FilterOperator(FilterOperator::IN), $carGroupId));
        }
        if (!empty($commercialGroupId)) {
            $planningFilterCollection->add(new Filter('commercialGroupId', new FilterOperator(FilterOperator::IN), $commercialGroupId));
        }
        if (!empty($carClassId)) {
            $planningFilterCollection->add(new Filter('carClassId', new FilterOperator(FilterOperator::IN), $carClassId));
        }
        if (!empty($connectedVehicleId)) {
            $planningFilterCollection->add(new Filter('connectedVehicleId', new FilterOperator(FilterOperator::IN), $connectedVehicleId));
        }
        if (!empty($pendingAssignmentsId)) {
            if(count($pendingAssignmentsId) == 1){
                $filterValue = $pendingAssignmentsId[0] == 1;
                $planningFilterCollection->add(new Filter('pendingAssignment', new FilterOperator(FilterOperator::EQUAL), $filterValue));
            }
        }

        if (!empty($fleetPlannerStatusId)) {
            $planningFilterCollection->add(new Filter('validated', new FilterOperator(FilterOperator::EQUAL), $fleetPlannerStatusId == 1));
        }

        $planning = $this->planningRepository->getPlanningBy(
            new PlanningFilterCriteria(
                $planningFilterCollection
                ));
        if (empty( $planning ) ){
            throw new PlanningException('Error getting planning');
        }

        $data = [];
        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();

        if(empty($branchCollection)){
            throw new BranchException('Error getting branch collection');
        }
            if ($planning->getPlanningLineCollection()) {
                 foreach ($planning->getPlanningLineCollection() as $planningLine) {
                    $checkLine=$planningLine->getValidated();
                     $brandList = [
                         'id' => $planningLine->getBrand()->getId(),
                         'name' => $planningLine->getBrand()->getName(),
                     ];
                     $modelList = [
                         'id' => $planningLine->getModel()->getId(),
                         'name' => $planningLine->getModel()->getName(),
                     ];
                     $purchaseMethodList = [
                         'id' => $planningLine->getPurchaseMethod()->getId(),
                         'name' => $planningLine->getPurchaseMethod()->getName(),
                     ];
                     $purchaseTypeList = [
                         'id' => $planningLine->getPurchaseType()->getId(),
                         'name' => $planningLine->getPurchaseType()->getName(),
                     ];
                     $gearBoxList = [];
                     if($planningLine->getGearBox()){
                         $gearBoxList = [
                             'id' => $planningLine->getGearBox()->getId(),
                             'name' => $planningLine->getGearBox()->getName(),
                         ];
                     }
                    $motorizationTypeList = [];
                     if($planningLine->getMotorizationType()){
                         $motorizationTypeList = [
                             'id' => $planningLine->getMotorizationType()->getId(),
                             'name' => $planningLine->getMotorizationType()->getName(),
                         ];
                     }
                     $acrissList = [];
                     if($planningLine->getAcriss()){
                         $acrissList = [
                             'id' => $planningLine->getAcriss()->getId(),
                             'name' => $planningLine->getAcriss()->getAcrissName(),
                         ];
                     }
                     $carGroupList = [];
                     if($planningLine->getCarGroup()){
                         $carGroupList = [
                             'id' => $planningLine->getCarGroup()->getId(),
                             'name' => $planningLine->getCarGroup()->getName(),
                         ];
                     }
                     $commercialClassList = [];
                     if($planningLine->getCommercialGroup()){
                         $commercialClassList = [
                             'id' => $planningLine->getCommercialGroup()->getId(),
                             'name' => $planningLine->getCommercialGroup()->getName(),
                         ];
                     }
                     $carClassList = [];
                     if($planningLine->getCarClass()){
                         $carClassList = [
                             'id' => $planningLine->getCarClass()->getId(),
                             'name' => $planningLine->getCarClass()->getName(),
                         ];
                     }
                     $connectedVehicleList =  $planningLine->getConnectedVehicle();

                    if ($planningLine->getAssignedVehicleCollection()) {
                        $delegation =  [];
                        foreach ($planningLine->getAssignedVehicleCollection() as $assignedVehicle) {
                            foreach ($branchCollection as $branch) {
                                if($branch->getBranchIATA() == $assignedVehicle->getBranch()->getBranchIATA()){
                                    $delegation[] = [
                                        'idBranch' => $assignedVehicle->getBranch()->getId(),
                                        'units' =>  $assignedVehicle->getUnit(),
                                    ];
                                }
                            }
                        }
                    }

                    $dataModel = [
                        'id' => $planningLine->getFleetPlanId(),
                        'brandList' => $brandList,
                        'modelList' => $modelList,
                        'purchaseMethodList' => $purchaseMethodList,
                        'purchaseTypeList' => $purchaseTypeList,
                        'gearBoxList' => $gearBoxList,
                        'motorizationTypeList' => $motorizationTypeList,
                        'acrissList' => $acrissList,
                        'carGroupList' => $carGroupList,
                        'carClassList' => $carClassList,
                        'commercialGroupList' => $commercialClassList,
                        'connectedVehicleList' => $connectedVehicleList,
                        'unitsTotal' => $planningLine->getUnitsTotal(),
                        'modelCode' => $planningLine->getModelCode(),
                        'delegations' => $delegation
                    ];

                    $data['body'][] = $dataModel;

                    $data['checkLine'][] = $checkLine;

                 }
             }

            if ($planning->getOrPlanPlanning()) {
                foreach ($planning->getOrPlanPlanning()->getDelegationCollection() as $delegation) {
                    foreach ($branchCollection as $branch) {
                        if ($branch->getBranchIATA() == $delegation->getBranch()->getBranchIATA()) {
                            $orPlan[] = $delegation->getOrPlan();
                            $branchIATA[] = $delegation->getBranch()->getBranchIATA();
                        }
                    }
                }
            }

        $totalRows = count($planning->getPlanningLineCollection());

        if($query->getOrPlan()){
            $orPlan = $query->getOrPlan();
        }
        if($query->getVehicleLinesId()){
            $data = $this->changeVehicleData($query->getVehicleLinesId(), $data);
        }

        $planningResponse['total'] = $totalRows;
        $planningResponse['planning'] = $data;
        $planningResponse['orPlan'] = $orPlan;
        $planningResponse['branch'] = $branchIATA;

        if($excel){
            /*$header = ['','','','','','','','','','','','',''];
            foreach ($planningResponse['branch'] as $branch) {
                array_push($header,$branch);
            }*/
            $body= $this->createArrayFormatter($planningResponse,$planning);
            return new FilterPlanningResponse($body);
        }else{
            return new FilterPlanningResponse($planningResponse);
        }
    }

    private function changeVehicleData($getVehicleLinesId,$data){
        foreach ($getVehicleLinesId as $key => $getVehicleLine ){
            $planningCount = count($data['body'][$key]);
            $row = $planningCount - count($getVehicleLine);
            foreach ( $getVehicleLine as $number ) {
                $data['body'][$key][$row] = $number;
                $row++;
            }
        }
        return $data;
    }

    private function createArrayFormatter( $planningResponse, $planning): array
    {
        $movementExcel = [];
        //OR PLAN
        $headerOrPlan=['','','','','','','','','','','','','OR PLAN'];
        foreach ([$planningResponse['orPlan']] as $key => $plan) {
            $movementExcel[]=(array_merge($headerOrPlan,$plan));
        }
        $header = [
            'Marca',
            'Modelo',
            'Metodo de compra',
            'Tipo de compra',
            'Caja de Cambios',
            'Tipo de motorización',
            'Acriss',
            'Grupos',
            'CarClass',
            'Grupo comercial',
            'Vehiculo conectado',
            'Total Unidades',
            'Asignaciones Pendientes'
        ];
        $movementExcel[] = $header;

        //planning
        $delegation = [];
        foreach ($planning->getPlanningLineCollection() as $key => $object) {

            $delegation[$key] = [];
            $assignedVehicles = 0;

            foreach ( $planningResponse['planning']['body'][$key] as $planningVehicles ) {
                if( isset( $planningVehicles['idBranch'] ) ) {
                    $delegation[$key][] = $planningVehicles['units'];
                    $assignedVehicles = $assignedVehicles + $planningVehicles['units'];
                }
            }

            $planningList = [
                $object->getBrand()->getName(),
                $object->getModel()->getName(),
                $object->getPurchaseMethod()->getName(),
                $object->getPurchaseType()->getName(),
                $object->getGearBox() ? $object->getGearBox()->getName() : null,
                $object->getMotorizationType() ?  $object->getMotorizationType()->getName(): null,
                $object->getAcriss() ? $object->getAcriss()->getName() : null,
                $object->getCarGroup() ?  $object->getCarGroup()->getName(): null,
                $object->getCarClass() ? $object->getCarClass()->getName(): null,
                $object->getCommercialGroup()  ? $object->getCommercialGroup()->getName() : null,
                $object->getConnectedVehicle(),
                $object->getUnitsTotal(),
                ($object->getUnitsTotal() - $assignedVehicles)
            ];

            $movementExcel[]= array_merge($planningList, $delegation[$key]);
        }

        $totalDistributedVehicle = [];
        $totalVn = [];

        foreach ( $delegation as $cars ){
            foreach ( $cars as $delegationId => $car){
                if(isset($totalDistributedVehicle[$delegationId])) {
                    $totalDistributedVehicle[$delegationId]=$totalDistributedVehicle[$delegationId]+$car;
                }else{
                    $totalDistributedVehicle[$delegationId]=$car;
                }
            }
        }

        $pendingDistributedVehicle = $totalDistributedVehicle;
        foreach ( $pendingDistributedVehicle as $key => $pendingVehicle ) {
            $pendingDistributedVehicle[$key] = $pendingVehicle - $planningResponse['orPlan'][$key];
        }

        $totalDistributed=['','','','','','','','','','','','','Total distribuido'];
        $movementExcel[]= array_merge($totalDistributed, $totalDistributedVehicle);

        $pendingDistributed=['','','','','','','','','','','','','Pendiente distribuido'];
        $movementExcel[]= array_merge($pendingDistributed, $pendingDistributedVehicle);

        $totalVn=['','','','','','','','','','','','','Total VN'];
        $movementExcel[]= array_merge($totalVn, $totalDistributedVehicle);

        return $movementExcel;
    }
}
