<?php
declare(strict_types=1);


namespace Distribution\Planning\Application\StorePlanning;


use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CarClass\Domain\CarClassRepository;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;
use Distribution\Planning\Domain\Acriss;
use Distribution\Planning\Domain\AssignedVehicle;
use Distribution\Planning\Domain\AssignedVehicleCollection;
use Distribution\Branch\Domain\Branch;
use Distribution\Planning\Domain\CarClass;
use Distribution\Planning\Domain\CarGroup;
use Distribution\Planning\Domain\CommercialGroup;
use Distribution\Planning\Domain\Delegation;
use Distribution\Planning\Domain\DelegationCollection;
use Distribution\Planning\Domain\OrPlanPlanning;
use Distribution\Planning\Domain\Planning;
use Distribution\Planning\Domain\PlanningException;
use Distribution\Planning\Domain\PlanningFilterCriteria;
use Distribution\Planning\Domain\PlanningLine;
use Distribution\Planning\Domain\PlanningLineCollection;
use Distribution\Planning\Domain\PlanningRepository;
use Shared\Domain\User;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Exception\NotFoundInCollectionException;

/**
 * Class StorePlanningCommandHandler
 * @package Distribution\Planning\Application\StorePlanning
 */
class StorePlanningCommandHandler
{
    /**
     * @var PlanningRepository
     */
    private PlanningRepository $planningRepository;
    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;
    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $carGroupRepository;
    /**
     * @var CarClassRepository
     */
    private CarClassRepository $carClassRepository;
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    /**
     * @param PlanningRepository $planningRepository
     * @param AcrissRepository $acrissRepository
     * @param CarGroupRepository $carGroupRepository
     * @param CarClassRepository $carClassRepository
     * @param CommercialGroupRepository $commercialGroupRepository
     */
    public function __construct(PlanningRepository $planningRepository, AcrissRepository $acrissRepository, CarGroupRepository $carGroupRepository, CarClassRepository $carClassRepository, CommercialGroupRepository $commercialGroupRepository)
    {
        $this->planningRepository = $planningRepository;
        $this->acrissRepository = $acrissRepository;
        $this->carGroupRepository = $carGroupRepository;
        $this->carClassRepository = $carClassRepository;
        $this->commercialGroupRepository = $commercialGroupRepository;
    }


    /**
     * @throws NotFoundInCollectionException
     * @throws PlanningException
     */
    final public function handle(StorePlanningCommand $command): StorePlanningResponse
    {
        $validatePlanning = false;
        $vehicleAssign = $command->getVehiclesId();
        $vehicleModel = $command->getModel();

        $month = $command->getMonth();
        $year = $command->getYear();
        $validate = $command->isValidated();
        $orPlan = $command->getOrPlan();

        $acrissSelected = $command->getAcrissSelected();


        if($validate==1){
            $validatePlanning=true;//validar
        }

        $planningFilterCollection = new FilterCollection([]);
        if(!empty($year)) {
            $planningFilterCollection->add(new Filter('year', new FilterOperator(FilterOperator::EQUAL), $year));
        }
        if(!empty($month)) {
            $planningFilterCollection->add(new Filter('month', new FilterOperator(FilterOperator::EQUAL), $month));
        }

        $planning = $this->planningRepository->getPlanningBy(
            new PlanningFilterCriteria(
                $planningFilterCollection
            ));
        if (empty( $planning ) ){
            throw new PlanningException('Error getting planning');
        }

        $planningLineCollection = new PlanningLineCollection([]);
        $oldPlanningLineCollection = $planning->getPlanningLineCollection();
        foreach ($vehicleAssign as $key => $objVehicle) {

            $oldPlanningLine = $oldPlanningLineCollection->getByProperty($vehicleModel[$key]['fleetPlanId'], 'fleetPlanId');

            $assignedVehicleCollection = new AssignedVehicleCollection([]);

            for($j=0; $j < count($objVehicle); $j++){
                $idBranch = $objVehicle[$j]['idBranch'];
                $units = $objVehicle[$j]['units'];

                $assignedVehicleCollection->add(new AssignedVehicle(
                    new Branch($idBranch),
                    $units
                ));

            }
            $fleetPlanId = $vehicleModel[$key]['fleetPlanId'];
            $modelCode = $vehicleModel[$key]['modelCode'];

            [$acrissPlanningLine, $carGroupPlanningLine, $carClassPlanningLine, $commercialGroupPlanningLine] = null;


            if($acrissSelected){
                foreach ($acrissSelected as $acrissId){
                    $keys = array_keys($acrissId);

                    foreach ($keys as $vehicleLineKey){
                        if($vehicleLineKey == $oldPlanningLine->getFleetPlanId()){
                            $acrissPlanningLine = new Acriss($acrissId[$vehicleLineKey]);
                            break;
                        }
                    }

                    if($acrissPlanningLine!=null){
                        break;
                    }
                }

                if($acrissPlanningLine !== null){
                    //TODO Recuperar CarGroup, carclass y CommercialGroup según Acriss

                    $acriss = $this->acrissRepository->getById($acrissPlanningLine->getId());

                    $carGroupPlanningLine = new CarGroup($acriss->getCarGroup()->getId(), $acriss->getCarGroup()->getName());
                    $carClassPlanningLine = new CarClass($acriss->getCarClass()->getId(), $acriss->getCarClass()->getName());


                    $commercialGroupCollection = $this->commercialGroupRepository->getBy(new CommercialGroupCriteria(new FilterCollection([new Filter('acrissId', new FilterOperator(FilterOperator::IN), [$acriss->getId()])])));

                    if($commercialGroupCollection->getTotalRows()>0){
                        $commercialGroup = $commercialGroupCollection->getCollection()[0];
                        $commercialGroupPlanningLine = new CommercialGroup($commercialGroup->getId(), $commercialGroup->getName());
                    }
                }
            }

            $planningLineCollection->add(new PlanningLine(
                $fleetPlanId,
                $modelCode,
                $assignedVehicleCollection,
                $validatePlanning,
                $oldPlanningLine->getBrand(),
                $oldPlanningLine->getModel(),
                $oldPlanningLine->getPurchaseMethod(),
                $oldPlanningLine->getPurchaseType(),
                $oldPlanningLine->getGearBox(),
                $oldPlanningLine->getMotorizationType(),
                $acrissPlanningLine ? : $oldPlanningLine->getAcriss(),
                $carGroupPlanningLine ? : $oldPlanningLine->getCarGroup(),
                $commercialGroupPlanningLine ? : $oldPlanningLine->GetCommercialGroup(),
                $carClassPlanningLine ? : $oldPlanningLine->getCarClass()
            ));
        }

        $delegationCollection = new DelegationCollection([]);
        foreach ($planning->getOrPlanPlanning()->getDelegationCollection() as $key => $objDelegation) {
              $delegationCollection->add(new Delegation(
                        new Branch($objDelegation->getBranch()->getId()),
                        $orPlan[$key]
                    )
                );
        }
        $orPlanPlanning = new OrPlanPlanning(
            $delegationCollection
        );
        $planningObject = new Planning(
            null,
            $year,
            $month,
            $planningLineCollection,
            $orPlanPlanning,
            new User(2),
            null,
            null,
            null
        );
        $movementStored = $this->planningRepository->store($planningObject);
        return new StorePlanningResponse($movementStored->getId());
    }
}