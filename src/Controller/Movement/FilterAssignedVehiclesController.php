<?php

namespace App\Controller\Movement;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Movement\Application\FilterAssignedVehiclesMovement\FilterAssignedVehiclesQuery;
use Distribution\Movement\Application\FilterAssignedVehiclesMovement\FilterAssignedVehiclesQueryHandler;

class FilterAssignedVehiclesController extends AbstractController
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
     * @return JsonResponse
     * 
     * @throws VehicleNotFoundException
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $query = new FilterAssignedVehiclesQuery(
                is_numeric($request->get('limit')) ? intval($request->get('limit')) : null,
                is_numeric($request->get('offset')) ? intval($request->get('offset')) : null,
                $request->get('order'),
                $request->get('sort'),
                intval($request->get('movementId'))
            );

            $response = $this->handler->handle($query, false);
        } catch (\Exception $e) {
            return $this->json($e->getMessage());
        }

        return $this->json(
            [
                'total' => $response->getTotalRows(),
                'rows' => $response->getRows(),
            ]
        );
    }
}
