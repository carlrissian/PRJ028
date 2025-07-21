<?php

namespace App\Controller\VehicleSeats;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\VehicleSeats\Application\SelectList\SelectListVehicleSeatsQueryHandler;

final class SelectListVehicleSeatsController extends AbstractController
{
    /**
     * @var SelectListVehicleSeatsQueryHandler
     */
    private $handler;

    /**
     * @param SelectListVehicleSeatsQueryHandler $handler
     */
    public function __construct(SelectListVehicleSeatsQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $response = $this->handler->handle();

            return $this->json($response->getSelectList());
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
