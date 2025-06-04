<?php

declare(strict_types=1);

namespace App\Controller\Vehicle;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\Vehicle\Application\IndexVehicle\IndexVehicleQuery;
use Distribution\Vehicle\Application\IndexVehicle\IndexVehicleQueryHandler;
use Distribution\Vehicle\Application\GetMotorizationType\GetMotorizationTypeQuery;
use Distribution\Vehicle\Application\GetMotorizationType\GetMotorizationTypeQueryHandler;
use Distribution\Vehicle\Application\ShowStatusChangeDocType\ShowStatusChangeDocTypeQuery;
use Distribution\Vehicle\Application\ShowStatusChangeDocType\ShowStatusChangeDocTypeQueryHandler;

class VehicleController extends Controller
{
    final public function getSelectors(IndexVehicleQueryHandler $handler): JsonResponse
    {
        $response = $handler->handler(new IndexVehicleQuery());

        return $this->json($response->getSelectList());
    }

    final public function showHistoryStatusDocumentInfo(Request $request, ShowStatusChangeDocTypeQueryHandler $handler): Response
    {
        $vehicleId = $request->get('vehicleId');
        $documentId = $request->get('documentId');
        $documentTypeId = $request->get('documentTypeId');
        $licensePlate = $request->get('licensePlate');
        $actualLoadDate = $request->get('actualLoadDate');

        $response = $handler->handle(new ShowStatusChangeDocTypeQuery(intval($documentTypeId), intval($vehicleId), intval($documentId), $licensePlate, $actualLoadDate));

        return $this->json($response);
    }

    /**
     * @param Request $request
     * @param GetMotorizationTypeQueryHandler $handler
     * @return JsonResponse
     */
    final public function getMotorizationType(Request $request, GetMotorizationTypeQueryHandler $handler): JsonResponse
    {
        $query = new GetMotorizationTypeQuery(intval($request->get('vehicleId')));
        $response = $handler->handle($query);

        return $this->json($response->getMotorizationType());
    }
}
