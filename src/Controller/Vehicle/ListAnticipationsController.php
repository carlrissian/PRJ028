<?php

namespace App\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Vehicle\Application\ListVehicleAnticipations\ListVehicleAnticipationsQuery;
use Distribution\Vehicle\Application\ListVehicleAnticipations\ListVehicleAnticipationsQueryHandler;

class ListAnticipationsController extends AbstractController
{
    /**
     * @var ListVehicleAnticipationsQueryHandler
     */
    private $handler;

    /**
     * @param ListVehicleAnticipationsQueryHandler $handler
     */
    public function __construct(ListVehicleAnticipationsQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return JsonResponse
     * 
     * @throws VehicleNotFoundException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $query = new ListVehicleAnticipationsQuery(intval($request->get('vehicleId')));
        $response = $this->handler->handle($query);

        return $this->json($response->getVehicleAnticipationResponse());
    }
}
