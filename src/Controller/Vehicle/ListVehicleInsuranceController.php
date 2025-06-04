<?php

namespace App\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\InsurancePolicies\Application\ListVehicleInsurancePolicies\ListVehicleInsurancePoliciesQuery;
use Distribution\InsurancePolicies\Application\ListVehicleInsurancePolicies\ListVehicleInsurancePoliciesQueryHandler;

class ListVehicleInsuranceController extends AbstractController
{

    /**
     * @var ListVehicleInsurancePoliciesQueryHandler
     */
    private $handler;

    /**
     * @param ListVehicleInsurancePoliciesQueryHandler $handler
     */
    public function __construct(ListVehicleInsurancePoliciesQueryHandler $handler)
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
            $query = new ListVehicleInsurancePoliciesQuery(intval($request->get('vehicleId')));

            $response = $this->handler->handle($query);
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
