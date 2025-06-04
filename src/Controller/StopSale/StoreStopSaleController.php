<?php

namespace App\Controller\StopSale;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\StopSale\Application\StoreStopSale\StoreStopSaleCommand;
use Distribution\StopSale\Application\StoreStopSale\StoreStopSaleCommandHandler;

class StoreStopSaleController extends AbstractController
{
    /**
     * @var StoreStopSaleCommandHandler
     */
    private $handler;

    /**
     * @param StoreStopSaleCommandHandler $handler
     */
    public function __construct(StoreStopSaleCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * 
     * @throws StopSaleException
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $stopSale = json_decode($request->get('stopSale'), true);

            $command = new StoreStopSaleCommand(
                $stopSale['categoryId'],
                $stopSale['departmentId'] ?? null,
                $stopSale['initDate'] ?? null,
                $stopSale['endDate'] ?? null,
                $stopSale['acrissId'] ?? null,
                $stopSale['regionPickUpId'] ?? null,
                $stopSale['regionDropOffId'] ?? null,
                $stopSale['areaPickUpId'] ?? null,
                $stopSale['areaDropOffId'] ?? null,
                $stopSale['branchPickUpId'] ?? null,
                $stopSale['branchDropOffId'] ?? null,
                $stopSale['partnersId'] ?? null,
                $stopSale['sellCodesId'] ?? null,
                $stopSale['productsId'] ?? null,
                $stopSale['stopSaleTypeId'] ?? null,
                $stopSale['startTime'] ?? null,
                $stopSale['endTime'] ?? null,
                $stopSale['recurrencesId'] ?? null,
                $stopSale['minDaysRent'] ? intval($stopSale['minDaysRent']) : null,
                $stopSale['maxDaysRent'] ? intval($stopSale['maxDaysRent']) : null,
                filter_var($stopSale['connectedVehicle'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
                $stopSale['notes']
            );

            $response = $this->handler->handle($command);

            return $this->json(['id' => $response->getId()]);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
