<?php

declare(strict_types=1);

namespace App\Controller\Acriss;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\Acriss\Application\UpdateAcriss\UpdateAcrissCommand;
use Distribution\Acriss\Application\UpdateAcriss\UpdateAcrissCommandHandler;

class UpdateAcrissController extends Controller
{
    /**
     * @var UpdateAcrissCommandHandler
     */
    private $handler;

    public function __construct(UpdateAcrissCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param integer $id
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            $branchTranslations = null;
            if ($request->get('branchTranslations')) {
                $branchTranslations = array_map(function ($branchTranslation) {
                    return json_decode($branchTranslation, true);
                }, $request->get('branchTranslations'));
            }

            $query = new UpdateAcrissCommand(
                $id,
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
                is_numeric($request->get('minAgeDLClassA2')) ? intval($request->get('minAgeDLClassA2')) : null,
                $branchTranslations
            );

            $response = $this->handler->handle($query);

            return $this->json(
                [
                    'acrissUpdated' => $response->isAcrissUpdated(),
                    'branchTranslationsUpdated' => $response->areBranchTranslationsUpdated(),
                ],
                $response->isAcrissUpdated() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR
                // TODO V1.2 de momento no se va a crear/actualizar desde frontend
                // $response->isAcrissUpdated() && $response->areBranchTranslationsUpdated() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
