<?php

declare(strict_types=1);

namespace Distribution\Planning\Application\ListPlanning;

use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use App\Constants\ConnectedVehicleConstants;
use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Model\Domain\ModelCriteria;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Brand\Domain\BrandException;
use Distribution\Model\Domain\ModelException;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Brand\Domain\BrandRepository;
use Distribution\Model\Domain\ModelRepository;
use Distribution\Branch\Domain\BranchException;
use Distribution\GearBox\Domain\GearBoxCriteria;
use Distribution\CarClass\Domain\CarClassCriteria;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\GearBox\Domain\GearBoxRepository;
use Distribution\CarClass\Domain\CarClassException;
use Distribution\CarGroup\Domain\CarGroupException;
use Distribution\CarClass\Domain\CarClassRepository;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\Acriss\Domain\InvalidAcrissException;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\GearBox\Domain\GearBoxNotFoundException;
use Distribution\PurchaseType\Domain\PurchaseTypeCriteria;
use Distribution\PurchaseType\Domain\PurchaseTypeException;
use Distribution\PurchaseType\Domain\PurchaseTypeRepository;
use Distribution\PurchaseMethod\Domain\PurchaseMethodCriteria;
use Distribution\PurchaseMethod\Domain\PurchaseMethodException;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\PurchaseMethod\Domain\PurchaseMethodRepository;
use Distribution\CommercialGroup\Domain\CommercialGroupException;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;
use Distribution\MotorizationType\Domain\MotorizationTypeCriteria;
use Distribution\MotorizationType\Domain\MotorizationTypeRepository;

class ListPlanningQueryHandler
{

    /**
     * @var BrandRepository
     */
    private BrandRepository $brandRepository;
    /**
     * @var ModelRepository
     */
    private ModelRepository $modelRepository;
    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $carGroupRepository;
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;
    /**
     * @var BranchRepository
     */
    private BranchRepository $branchRepository;
    /**
     * @var PurchaseMethodRepository
     */
    private PurchaseMethodRepository $purchaseMethodRepository;
    /**
     * @var PurchaseTypeRepository
     */
    private PurchaseTypeRepository $purchaseTypeRepository;
    /**
     * @var GearBoxRepository
     */
    private GearBoxRepository $gearBoxRepository;
    /**
     * @var MotorizationTypeRepository
     */
    private MotorizationTypeRepository $motorizationTypeRepository;
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;
    /**
     * @var CarClassRepository
     */
    private CarClassRepository $carClassRepository;


    /**
     * ListPlanningQueryHandler constructor.
     * @param BrandRepository $brandRepository
     * @param ModelRepository $modelRepository
     * @param CarGroupRepository $carGroupRepository
     * @param CommercialGroupRepository $commercialGroupRepository
     * @param BranchRepository $branchRepository
     * @param PurchaseMethodRepository $purchaseMethodRepository
     * @param PurchaseTypeRepository $purchaseTypeRepository
     * @param GearBoxRepository $gearBoxRepository
     * @param MotorizationTypeRepository $motorizationTypeRepository
     * @param AcrissRepository $acrissRepository
     * @param CarClassRepository $carClassRepository
     */
    public function __construct(BrandRepository $brandRepository, ModelRepository $modelRepository, CarGroupRepository $carGroupRepository, CommercialGroupRepository $commercialGroupRepository, BranchRepository $branchRepository, PurchaseMethodRepository $purchaseMethodRepository, PurchaseTypeRepository $purchaseTypeRepository, GearBoxRepository $gearBoxRepository, MotorizationTypeRepository $motorizationTypeRepository, AcrissRepository $acrissRepository, CarClassRepository $carClassRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        $this->carGroupRepository = $carGroupRepository;
        $this->commercialGroupRepository = $commercialGroupRepository;
        $this->branchRepository = $branchRepository;
        $this->purchaseMethodRepository = $purchaseMethodRepository;
        $this->purchaseTypeRepository = $purchaseTypeRepository;
        $this->gearBoxRepository = $gearBoxRepository;
        $this->motorizationTypeRepository = $motorizationTypeRepository;
        $this->acrissRepository = $acrissRepository;
        $this->carClassRepository = $carClassRepository;
    }


    /**
     * @throws PurchaseTypeException
     * @throws CommercialGroupException
     * @throws ModelException
     * @throws PurchaseMethodException
     * @throws CarGroupException
     * @throws InvalidAcrissException
     * @throws BrandException
     * @throws CarClassException
     * @throws GearBoxNotFoundException
     * @throws BranchException
     */
    public function handle(ListPlanningQuery $query): ListPlanningResponse
    {

        $brandCollection = $this->brandRepository->getBy(new BrandCriteria())->getCollection();
        if(empty($brandCollection)){
            throw new BrandException('Error getting brand collection');
        }
        $modelCollection = $this->modelRepository->getBy(new ModelCriteria())->getCollection();
        if(empty($modelCollection)){
            throw new ModelException('Error getting model collection');
        }
        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        if(empty($carGroupCollection)){
            throw new CarGroupException('Error getting car group collection');
        }

        $commercialGroupCollection = $this->commercialGroupRepository->getBy(new CommercialGroupCriteria() )->getCollection();
        if(empty($commercialGroupCollection)){
            throw new CommercialGroupException('Error getting commercial group collection');
        }

        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();
        if(empty($branchCollection)){
            throw new BranchException('Error getting branch collection');
        }

        $purchaseMethodCollection = $this->purchaseMethodRepository->getBy(new PurchaseMethodCriteria())->getCollection();
        if(empty($purchaseMethodCollection)){
            throw new PurchaseMethodException('Error getting purchaseMethod collection');
        }
        $purchaseTypeCollection = $this->purchaseTypeRepository->getBy(new PurchaseTypeCriteria())->getCollection();
        if(empty($purchaseTypeCollection)){
            throw new PurchaseTypeException('Error getting purchaseType collection');
        }
        $gearBoxCollection = $this->gearBoxRepository->getBy(new GearBoxCriteria())->getCollection();
        if(empty($gearBoxCollection)){
            throw new GearBoxNotFoundException('Error getting gearBox collection');
        }
        $motorizationTypeCollection = $this->motorizationTypeRepository->getBy(new MotorizationTypeCriteria())->getCollection();
        if(empty($motorizationTypeCollection)){
            throw new PurchaseTypeException('Error getting motorizationType collection');
        }

        // CARGAR LOS ACRISS ACTIVOS (CON GRUPO FLOTA Y GRUPO COMERCIAL)
        $acrissIdsAdded = [];
        $acrissAddedList = [];
        $acrissFilterCollection = new FilterCollection([]);
        $acrissFilterCollection->add(new Filter('carGroupId', new FilterOperator(FilterOperator::NOT_EQUAL), null));
        foreach($commercialGroupCollection as $key => $commercialGroup){
            foreach($commercialGroup->getAcriss() as $acrissCommercialGroup){
                if(!in_array($acrissCommercialGroup->getId(), $acrissIdsAdded)){
                    $acrissIdsAdded[] = $acrissCommercialGroup->getId();
                    $acrissAddedList[] = [ 'id' => $acrissCommercialGroup->getId(), 'commercialGroupName' => $commercialGroup->getName()];
                }
            }
        }
        $acrissFilterCollection->add(new Filter('id', new FilterOperator(FilterOperator::IN), $acrissIdsAdded));

        $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria($acrissFilterCollection))->getCollection();
        if(empty($acrissCollection)){
            throw new InvalidAcrissException('Error getting acriss collection');
        }

        $carClassCollection = $this->carClassRepository->getBy(new CarClassCriteria())->getCollection();
        if(empty($carClassCollection)){
            throw new CarClassException('Error getting carClass collection');
        }

        $brandList = [];
        foreach ($brandCollection as $brand){
            $brandList[] = [
                'id' => $brand->getId(),
                'name' => $brand->getName(),
            ];
        }
        $modelList = [];
        foreach ($modelCollection as $model){
            $modelList[] = [
                'id' => $model->getId(),
                'name' => $model->getName(),
            ];
        }
        $carGroupList = [];
        foreach ($carGroupCollection as $carGroup){
            $carGroupList[] = [
                'id' => $carGroup->getId(),
                'name' => $carGroup->getName(),
            ];
        }

        $commercialGroupList = [];
        foreach ($commercialGroupCollection as $commercialGroup){
            $commercialGroupList[] = [
                'id' => $commercialGroup->getId(),
                'name' => $commercialGroup->getName(),
            ];
        }

        $branchList = [];
        foreach ($branchCollection as $branch){
            $branchList[] = [
                'id' => $branch->getId(),
                'name' => $branch->getName(),
                'branchIATA'=> $branch->getBranchIATA()
            ];
        }
        $purchaseMethodList = [];
        foreach ($purchaseMethodCollection as $purchaseMethod){
            $purchaseMethodList[] = [
                'id' => $purchaseMethod->getId(),
                'name' => $purchaseMethod->getName(),
            ];
        }
        $purchaseTypeList = [];
        foreach ($purchaseTypeCollection as $purchaseType){
            $purchaseTypeList[] = [
                'id' => $purchaseType->getId(),
                'name' => $purchaseType->getName(),
            ];
        }
        $gearBoxList = [];
        foreach ($gearBoxCollection as $gearBox){
            $gearBoxList[] = [
                'id' => $gearBox->getId(),
                'name' => $gearBox->getName(),
            ];
        }
        $motorizationTypeList = [];
        foreach ($motorizationTypeCollection as $motorizationType){
            $motorizationTypeList[] = [
                'id' => $motorizationType->getId(),
                'name' => $motorizationType->getName(),
            ];
        }

        //TODO modificar lógica para selectores acriss
        $acrissList = [];
        foreach ($acrissCollection as $acriss){
            $commercialGroupName = '';
            foreach($acrissAddedList as $acrissAdd){
                if($acriss->getId() === $acrissAdd['id']){
                    $commercialGroupName.= $acrissAdd['commercialGroupName']. ', ';
                }
            }
            if($commercialGroupName!==''){
                $commercialGroupName = substr($commercialGroupName, 0, -2);
            }

            $acrissList[] = [
                'id' => $acriss->getId(),
                'name' => $acriss->getAcrissName(),
                'commercialGroupName' => $commercialGroupName,
                'carGroup' => $acriss->getCarGroup() ? $acriss->getCarGroup()->getName() : '-',
                'carClass' => $acriss->getCarClass()->getName(),
            ];
        }

        $carClassList = [];
        foreach ($carClassCollection as $carClass){
            $carClassList[] = [
                'id' => $carClass->getId(),
                'name' => $carClass->getName(),
            ];
        }

        $connectedVehicleList = [];
        $connectedVehicleList [] = [
            'id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_YES,
            'name' => 'Si'
        ];
        $connectedVehicleList [] = [
            'id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_NO,
            'name' => 'No'
        ];


        $pendingAssignmentsList = [];
        $pendingAssignmentsList[] = [
            'id' => 1,
            'name' => 'Si',
        ];
        $pendingAssignmentsList[] = [
            'id' => 0,
            'name' => 'No',
        ];

        $fleetPlannerStatusList = [
            ['id' => 0, 'name' => 'Pendiente'],
            ['id' => 1, 'name' => 'Validado']
        ];

        $monthList = [];
        for($i = 1; $i<=12; $i++){
            $monthName = date("F",mktime(0,0,0,$i));
            $monthList[] = [
                'id' => $i,
                'name' => $monthName,
            ];
        }

        return new ListPlanningResponse($brandList,$modelList,$carGroupList,$commercialGroupList,$branchList,$purchaseMethodList,$purchaseTypeList,$gearBoxList,$motorizationTypeList,$acrissList,$carClassList,$connectedVehicleList,$pendingAssignmentsList,$fleetPlannerStatusList,$monthList);
    }
}
