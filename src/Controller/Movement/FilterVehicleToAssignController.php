<?php

namespace App\Controller\Movement;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Movement\Application\FilterVehicleToAssign\FilterVehicleToAssignQuery;
use Distribution\Movement\Application\FilterVehicleToAssign\FilterVehicleToAssignQueryHandler;
use App\Constants\ConnectedVehicleConstants;

class FilterVehicleToAssignController extends AbstractController
{
    /**
     * @var FilterVehicleToAssignQueryHandler
     */
    private $handler;

    /**
     * @param FilterVehicleToAssignQueryHandler $handler
     */
    public function __construct(FilterVehicleToAssignQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * 
     * @throws VehicleNotFoundException
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $query = new FilterVehicleToAssignQuery(
                is_numeric($request->get('limit')) ? intval($request->get('limit')) : null,
                is_numeric($request->get('offset')) ? intval($request->get('offset')) : null,
                $request->get('order'),
                $request->get('sort'),
                intval($request->get('movementId')),
                intval($request->get('movementTypeId')),
                is_numeric($request->get('locationId')) ? intval($request->get('locationId')) : null,
                $request->get('vehicleTypeId'),
                $request->get('brandId'),
                $request->get('modelId'),
                $request->get('carGroupId'),
                is_numeric($request->get('kmFrom')) ? floatval($request->get('kmFrom')) : null,
                is_numeric($request->get('kmTo')) ? floatval($request->get('kmTo')) : null,
                $request->get('rentingEndDateFrom'),
                $request->get('rentingEndDateTo'),
                $request->get('saleMethodId'),
                $request->get('checkInDateFrom'),
                $request->get('vehicleStatusId'),
                is_numeric($request->get('checkInLocation')) ? intval($request->get('checkInLocation')) : null,
                $request->get('connectedVehicle') !== null
                    ? (intval($request->get('connectedVehicle')) === ConnectedVehicleConstants::CONNECTED_VEHICLE_YES
                        ? true
                        : (intval($request->get('connectedVehicle')) === ConnectedVehicleConstants::CONNECTED_VEHICLE_NO
                            ? false
                            : null))
                    : null
            );

            $response = $this->handler->handle($query, false);
        } catch (\Exception $e) {
            return $this->json($e->getMessage());
        }

        return $this->json(
            [
                'total' => $response->getTotalRows(),
                'rows' => $response->getRows(),
                'success' => $response->wasSuccess(),
                'message' => $response->getMessage(),
            ],
            $response->getCode()
        );
    }
}
