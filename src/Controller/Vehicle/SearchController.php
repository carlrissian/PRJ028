<?php

namespace App\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Vehicle\Application\SearchVehicle\SearchVehicleQuery;
use Distribution\Vehicle\Application\SearchVehicle\SearchVehicleQueryHandler;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    /**
     * @var SearchVehicleQueryHandler
     */
    private $handler;

    /**
     * @param SearchVehicleQueryHandler $handler
     */
    public function __construct(SearchVehicleQueryHandler $handler)
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
        try {
            $query = new SearchVehicleQuery(
                $request->get('licensePlate'),
                $request->get('vin')
            );

            $response = $this->handler->handle($query);

            return $this->json([
                "exist" => $response->doesExist(),
                "vehicle" => $response->getVehicle(),
            ], $response->doesExist() ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
