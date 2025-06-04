<?php

namespace App\Controller\Movement;

use App\Helpers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Movement\Application\FilterVehicleToAssign\FilterVehicleToAssignQuery;
use Distribution\Movement\Application\FilterVehicleToAssign\FilterVehicleToAssignQueryHandler;

class DownloadVehicleToAssignListController extends AbstractController
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
     * @return StreamedResponse|JsonResponse
     * 
     * @throws VehicleNotFoundException
     */
    public function __invoke(Request $request)
    {
        try {
            $movementId = intval($request->get('movementId'));

            $query = new FilterVehicleToAssignQuery(
                null,
                null,
                null,
                null,
                $movementId,
                intval($request->get('movementTypeId')),
                is_numeric($request->get('locationId')) ? intval($request->get('locationId')) : null
            );

            $response = $this->handler->handle($query, true);
        } catch (\Exception $e) {
            return $this->json($e->getMessage());
        }

        return $response->wasSuccess() ?
            Helpers::exportCsv(
                $response->getRows(),
                null,
                "movement_{$movementId}_vehicle_to_assign_list.csv"
            ) :
            $this->json(
                [
                    'success' => $response->wasSuccess(),
                    'message' => $response->getMessage(),
                ],
                $response->getCode()
            );
    }
}
