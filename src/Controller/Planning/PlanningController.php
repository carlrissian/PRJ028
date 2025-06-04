<?php
declare(strict_types=1);

namespace App\Controller\Planning;

use App\Helpers;
use App\Controller\Controller;
use Distribution\Acriss\Domain\InvalidAcrissException;
use Distribution\Branch\Domain\BranchException;
use Distribution\Brand\Domain\BrandException;
use Distribution\CarClass\Domain\CarClassException;
use Distribution\CarGroup\Domain\CarGroupException;
use Distribution\CommercialGroup\Domain\CommercialGroupException;
use Distribution\GearBox\Domain\GearBoxNotFoundException;
use Distribution\Model\Domain\ModelException;
use Distribution\Planning\Application\FilterPlanning\FilterPlanningQuery;
use Distribution\Planning\Application\FilterPlanning\FilterPlanningQueryHandler;
use Distribution\Planning\Application\ListPlanning\ListPlanningQuery;
use Distribution\Planning\Application\ListPlanning\ListPlanningQueryHandler;
use Distribution\Planning\Application\StorePlanning\StorePlanningCommand;
use Distribution\Planning\Application\StorePlanning\StorePlanningCommandHandler;
use Distribution\Planning\Domain\PlanningException;
use Distribution\PurchaseMethod\Domain\PurchaseMethodException;
use Distribution\PurchaseType\Domain\PurchaseTypeException;
use Shared\Domain\Exception\NotFoundInCollectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PlanningController extends Controller
{
    /**
     * @throws PlanningException
     * @throws BranchException
     */
    public function filter(Request $request, FilterPlanningQueryHandler $handler):Response
    {

        $month = (int) $request->get('month');
        $year = (int) $request->get('year');
        $brandId = json_decode($request->get('brandId'));
        $modelId = json_decode($request->get('modelId'));
        $purchaseMethodId = json_decode($request->get('purchaseMethodId'));
        $purchaseTypeId = json_decode($request->get('purchaseTypeId'));
        $gearBoxId = json_decode($request->get('gearBoxId'));
        $motorizationTypeId = json_decode($request->get('motorizationTypeId'));
        $acrissId = json_decode($request->get('acrissId'));
        $carGroupId = json_decode($request->get('carGroupId'));
        $commercialGroupId = json_decode($request->get('commercialGroupId'));
        $carClassId = json_decode($request->get('carClassId'));

        $connectedVehicleId = false;
//        switch (json_decode($request->get('connectedVehicleId'))[0]){
//            case 'true':
//                $connectedVehicleId = true;
//                break;
//            case 'false':
//                $connectedVehicleId = false;
//                break;
//        }

        $pendingAssignmentsId = json_decode($request->get('pendingAssignmentsId'));
        $fleetPlannerStatusId = json_decode($request->get('fleetPlannerStatusId'));

        $query = new FilterPlanningQuery($month, $brandId, $modelId, $purchaseMethodId, $purchaseTypeId, $gearBoxId, $motorizationTypeId, $acrissId, $carGroupId, $commercialGroupId, $carClassId, $connectedVehicleId, $pendingAssignmentsId, $fleetPlannerStatusId, $year);

        $response = $handler->handle($query,false);

        return $this->json($response->getPlanning());
    }

    /**
     * @throws PurchaseTypeException
     * @throws CommercialGroupException
     * @throws PurchaseMethodException
     * @throws ModelException
     * @throws CarGroupException
     * @throws BrandException
     * @throws InvalidAcrissException
     * @throws CarClassException
     * @throws BranchException
     * @throws GearBoxNotFoundException
     */
    public function list(ListPlanningQueryHandler $handler):Response
    {
        $response = $handler->handle(new ListPlanningQuery());
        $selectList = $this->json($response)->getContent();

        return $this->render('pages/planning/list.html.twig', ['selectList' => $selectList]);
    }

    /**
     * @throws NotFoundInCollectionException
     */
    public function store(Request $request, StorePlanningCommandHandler $storePlanningCommandHandler): Response
    {
        $vehicleLinesId = $request->get('vehicleLinesId');
        $model = $request->get('model');
        $orPlan = $request->get('orPlan');
        $validate = $request->get('validate');
        $month = $request->get('month');
        $year= $request->get('year');
        $acrissSelected = $request->get('acrissSelected');

        $command = new StorePlanningCommand($vehicleLinesId,$model,$orPlan,$validate,$month,$year, $acrissSelected);
        try {
            $response = $storePlanningCommandHandler->handle($command);
            if ($validate==0) {
                $val='Guardado';
            } elseif ($validate==1) {
                $val='Validado';
            } else {
                $val='Reactidado';
            }
            return $this->json(['responseStatus' => true, 'message' => "Planning $val correctamente"]);
        } catch (PlanningException $e) {
            return $this->json(['responseStatus' => false, 'message' => 'Ha habido un problema al editar el planning']);
        }
    }

    /**
     * @throws PlanningException
     * @throws BranchException
     */
    public function downloadExcelPlanning(Request $request, FilterPlanningQueryHandler $handler):Response {

        $month = $request->get('month');
        $year = $request->get('year');
        $brandId = json_decode($request->get('brandId'));
        $modelId = json_decode($request->get('modelId'));
        $purchaseMethodId = json_decode($request->get('purchaseMethodId'));
        $purchaseTypeId = json_decode($request->get('purchaseTypeId'));
        $gearBoxId = json_decode($request->get('gearBoxId'));
        $motorizationTypeId = json_decode($request->get('motorizationTypeId'));
        $acrissId = json_decode($request->get('acrissId'));
        $carGroupId = json_decode($request->get('carGroupId'));
        $commercialGroupId = json_decode($request->get('carGroupId'));
        $carClassId = json_decode($request->get('carClassId'));
        $connectedVehicleId = json_decode($request->get('connectedVehicleId'));
        $pendingAssignmentsId = json_decode($request->get('pendingAssignmentsId'));
        $fleetPlannerStatusId = json_decode($request->get('fleetPlannerStatusId'));
        $vehicleLinesId = $request->get('vehicleLinesId');
        $orPlan = $request->get('orPlan');

        $query = new FilterPlanningQuery($month, $brandId, $modelId,$purchaseMethodId,$purchaseTypeId,$gearBoxId,$motorizationTypeId,$acrissId,$carGroupId,$commercialGroupId,$carClassId,$connectedVehicleId,$pendingAssignmentsId,$fleetPlannerStatusId,$year,$vehicleLinesId,$orPlan);

        $response = $handler->handle($query,true);//le pasamos true para tratar el excel
        $planning = $response->getPlanning();

        return Helpers::exportCsv(
           $planning,
            null,
            'planning_'.$month.'/'.$year.'.csv'
        );
    }


}
