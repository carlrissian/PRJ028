<?php

namespace App\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Vehicle\Application\FilterVehicleHistory\FilterVehicleHistoryQuery;
use Distribution\Vehicle\Application\FilterVehicleHistory\FilterVehicleHistoryQueryHandler;

class FilterVehicleHistoryController extends AbstractController
{

    /**
     * @var FilterVehicleHistoryQueryHandler
     */
    private $handler;

    /**
     * @param FilterVehicleHistoryQueryHandler $handler
     */
    public function __construct(FilterVehicleHistoryQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $sortOptions = [
            'originStatus' => "VEHICLEORIGINSTATUSNAME",
            'endStatus' => "VEHICLEENDSTATUSNAME",
            'location' => "LOCATIONNAME",
            'branch' => "BRANCHINTNAME",
            'kilometers' => "VEHICLEKMS",
            'statusChangeDate' => "STATUSCHANGEDATE",
            'statusChangeUser' => "STATUSCHANGEUSER",
            'undefined' => null,
            'default' => null
        ];

        try {
            $query = new FilterVehicleHistoryQuery(
                intval($request->get('limit', 10)),
                intval($request->get('offset', 0)),
                $sortOptions[$request->get('sort', 'default')],
                $request->get('order'),
                intval($request->get('vehicleId')),
                $request->get('originStatusId') ? intval($request->get('originStatusId')) : null,
                $request->get('endStatusId') ? intval($request->get('endStatusId')) : null,
                $request->get('statusChangeDateFrom'),
                $request->get('statusChangeDateTo')
            );

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
