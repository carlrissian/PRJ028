<?php

namespace App\Controller\Route;

use Distribution\Route\Application\Filter\FilterRouteQuery;
use Distribution\Route\Application\Filter\FilterRouteQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FilterRouteController extends AbstractController
{
    /**
     * @var FilterRouteQueryHandler
     */
    private FilterRouteQueryHandler $handler;

    /**
     * @param FilterRouteQueryHandler $handler
     */
    public function __construct(FilterRouteQueryHandler $handler)
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
            'transportMethod' => "TRANSPORTMETHODID",
            'provider' => "TRANSPORTPROVIDERID",
            'originBranch' => "BRANCHORIGINID",
            'destinationBranch' => "BRANCHDESTINYID",
            'fullTruckLoadAmount' => "COMPLETELOADAMOUNT",
            'vehicleAmount1' => "VEHICLEAMOUNT1",
            'vehicleAmount2' => "VEHICLEAMOUNT2",
            'vehicleAmount3' => "VEHICLEAMOUNT3",
            'vehicleAmount4' => "VEHICLEAMOUNT4",
            'vehicleAmount5' => "VEHICLEAMOUNT5",
            'vehicleAmount6' => "VEHICLEAMOUNT6",
            'vehicleAmount7' => "VEHICLEAMOUNT7",
            'vehicleAmount8' => "VEHICLEAMOUNT8",
            'vehicleAmount9' => "VEHICLEAMOUNT9",
            'vehicleAmount10' => "VEHICLEAMOUNT10",
            'sUVLoadAmount' => "SUVLOADAMOUNT",
            'vanLoadAmount' => "VANLOADAMOUNT",
            'undefined' => "CREATIONDATE",
            'default' => "CREATIONDATE"
        ];

        $query = new FilterRouteQuery(
            intval($request->get('limit', 10)),
            intval($request->get('offset', 0)),
            $sortOptions[$request->get('sort', 'default')],
            $request->get('order'),
            is_numeric($request->get('transportMethodId')) ? intval($request->get('transportMethodId')) : null,
            is_numeric($request->get('providerId')) ? intval($request->get('providerId')) : null,
            is_numeric($request->get('originBranchId')) ? intval($request->get('originBranchId')) : null,
            is_numeric($request->get('destinationBranchId')) ? intval($request->get('destinationBranchId')) : null
        );

        $response = $this->handler->handle($query);

        return $this->json([
            'total' => $response->getTotalRows(),
            'rows' => $response->getRows()
        ]);
    }
}
