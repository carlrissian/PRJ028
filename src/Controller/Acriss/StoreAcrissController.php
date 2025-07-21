<?php

namespace App\Controller\Acriss;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Acriss\Application\StoreAcriss\StoreAcrissCommand;
use Distribution\Acriss\Application\StoreAcriss\StoreAcrissCommandHandler;

class StoreAcrissController extends AbstractController
{
    /**
     * @var StoreAcrissCommandHandler
     */
    private $handler;

    /**
     * @param StoreAcrissCommandHandler $handler
     */
    public function __construct(StoreAcrissCommandHandler $handler)
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
            $query = new StoreAcrissCommand(
                intval($request->get('carClassId')),
                intval($request->get('vehicleTypeId')),
                intval($request->get('gearBoxId')),
                intval($request->get('motorizationTypeId')),
                $request->get('acrissCode', ''),
                $request->get('marketingStartDate') != 'null' ? $request->get('marketingStartDate') : null,
                $request->get('marketingEndDate') != 'null' ? $request->get('marketingEndDate') : null,
                filter_var($request->get('commercialVehicle'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
                filter_var($request->get('mediumTerm'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
                is_numeric($request->get('numberOfSuitcases')) ? intval($request->get('numberOfSuitcases')) : null,
                is_numeric($request->get('vehicleSeatsId')) ? intval($request->get('vehicleSeatsId')) : null,
                is_numeric($request->get('numberOfDoors')) ? intval($request->get('numberOfDoors')) : null,
                is_numeric($request->get('minAge')) ? intval($request->get('minAge')) : null,
                is_numeric($request->get('maxAge')) ? intval($request->get('maxAge')) : null,
                is_numeric($request->get('minAgeDLClassB')) ?? null,
                is_numeric($request->get('minAgeDLClassA')) ?? null,
                is_numeric($request->get('minAgeDLClassA1')) ?? null,
                is_numeric($request->get('minAgeDLClassA2')) ?? null,
                is_numeric($request->get('minAgeDLClassB')) ? intval($request->get('minAgeDLClassB')) : null,
                is_numeric($request->get('minAgeDLClassA')) ? intval($request->get('minAgeDLClassA')) : null,
                is_numeric($request->get('minAgeDLClassA1')) ? intval($request->get('minAgeDLClassA1')) : null,
                is_numeric($request->get('minAgeDLClassA2')) ? intval($request->get('minAgeDLClassA2')) : null
            );

            $response = $this->handler->handle($query);

            return $this->json(
                [
                    'id' => $response->getId(),
                    'childIds' => $response->getChildAcrissIds(),
                ],
                $response->isCreated() ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
