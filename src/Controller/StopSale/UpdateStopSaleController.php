<?php

namespace App\Controller\StopSale;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\StopSale\Domain\Exception\StopSaleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\StopSale\Application\UpdateStopSale\UpdateStopSaleCommand;
use Distribution\StopSale\Application\UpdateStopSale\UpdateStopSaleCommandHandler;

final class UpdateStopSaleController extends AbstractController
{
    /**
     * @var UpdateStopSaleCommandHandler
     */
    private $handler;

    /**
     * @param UpdateStopSaleCommandHandler $handler
     */
    public function __construct(UpdateStopSaleCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * 
     * @throws StopSaleException
     */
    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            $stopSale = json_decode($request->get('stopSale'), true);

            $command = new UpdateStopSaleCommand(
                $id,
                $stopSale['categoryId'],
                $stopSale['departmentId'] ?? null,
                $stopSale['initDate'] ?? null,
                $stopSale['endDate'] ?? null,
                $stopSale['acrissId'] ?? null,
                $stopSale['pickUpRegionId'] ?? null,
                $stopSale['pickUpAreaId'] ?? null,
                $stopSale['pickUpBranchId'] ?? null,
                $stopSale['dropOffRegionId'] ?? null,
                $stopSale['dropOffAreaId'] ?? null,
                $stopSale['dropOffBranchId'] ?? null,
                $stopSale['partnersId'] ?? null,
                $stopSale['sellCodesId'] ?? null,
                $stopSale['productsId'] ?? null,
                $stopSale['stopSaleTypeId'] ?? null,
                $stopSale['startTime'] ?? null,
                $stopSale['endTime'] ?? null,
                $stopSale['recurrencesId'] ?? null,
                $stopSale['minDaysRent'] ? intval($stopSale['minDaysRent']) : null,
                $stopSale['maxDaysRent'] ? intval($stopSale['maxDaysRent']) : null,
                isset($stopSale['connectedVehicle']) ? filter_var($stopSale['connectedVehicle'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null,
                $stopSale['notes']
            );

            $response = $this->handler->handle($command);

            return $this->json(['id' => $response->getId()]);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
