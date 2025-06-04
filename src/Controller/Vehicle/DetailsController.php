<?php

namespace App\Controller\Vehicle;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Vehicle\Application\ShowVehicle\ShowVehicleQuery;
use Distribution\Vehicle\Application\ShowVehicle\ShowVehicleQueryHandler;

class DetailsController extends Controller
{
    /**
     * @var ShowVehicleQueryHandler
     */
    private $handler;

    /**
     * @param ShowVehicleQueryHandler $handler
     */
    public function __construct(ShowVehicleQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return Response
     */
    public function __invoke(string $licensePlate): Response
    {
        try {
            $query = new ShowVehicleQuery($licensePlate);
            $response = $this->handler->handle($query);

            return $this->render('pages/vehicle/details.html.twig', ['vehicle' => $this->json($response->getVehicle())->getContent()]);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 500);
        }
    }
}
