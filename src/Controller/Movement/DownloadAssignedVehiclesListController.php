<?php

namespace App\Controller\Movement;

use App\Helpers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Movement\Application\FilterAssignedVehiclesMovement\FilterAssignedVehiclesQuery;
use Distribution\Movement\Application\FilterAssignedVehiclesMovement\FilterAssignedVehiclesQueryHandler;

class DownloadAssignedVehiclesListController extends AbstractController
{
    /**
     * @var FilterAssignedVehiclesQueryHandler
     */
    private $handler;

    /**
     * @param FilterAssignedVehiclesQueryHandler $handler
     */
    public function __construct(FilterAssignedVehiclesQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return StreamedResponse
     * 
     * @throws VehicleNotFoundException
     */
    public function __invoke(Request $request): StreamedResponse
    {
        try {
            $movementId = intval($request->get('movementId'));
            $filename = "details_movement_$movementId.csv";

            $query = new FilterAssignedVehiclesQuery(
                null,
                null,
                null,
                null,
                $movementId
            );

            $response = $this->handler->handle($query, true);
        } catch (\Exception $e) {
            return $this->json($e->getMessage());
        }

        return Helpers::exportCsv(
            $response->getRows(),
            null,
            $filename
        );
    }
}
