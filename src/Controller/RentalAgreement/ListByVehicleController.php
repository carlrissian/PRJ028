<?php

namespace App\Controller\RentalAgreement;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\RentalAgreement\Application\ListRentalAgreementByVehicle\ListRentalAgreementByVehicleQuery;
use Distribution\RentalAgreement\Application\ListRentalAgreementByVehicle\ListRentalAgreementByVehicleQueryHandler;

class ListByVehicleController extends AbstractController
{
    /**
     * @var ListRentalAgreementByVehicleQueryHandler
     */
    private ListRentalAgreementByVehicleQueryHandler $handler;

    /**
     * @param ListRentalAgreementByVehicleQueryHandler $handler
     */
    public function __construct(ListRentalAgreementByVehicleQueryHandler $handler)
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
            $query = new ListRentalAgreementByVehicleQuery(intval($request->get("vehicleId")));

            $response = $this->handler->handle($query);

            return $this->json(
                [
                    'total' => $response->getTotalRows(),
                    'rows' => $response->getRows(),
                ]
            );
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
