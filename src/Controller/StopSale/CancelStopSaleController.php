<?php

namespace App\Controller\StopSale;

use Distribution\StopSale\Application\CancelStopSale\CancelStopSaleCommand;
use Distribution\StopSale\Application\CancelStopSale\CancelStopSaleCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CancelStopSaleController extends AbstractController
{
    /**
     * @var CancelStopSaleCommandHandler
     */
    private $handler;

    /**
     * @param CancelStopSaleCommandHandler $handler
     */
    public function __construct(CancelStopSaleCommandHandler $handler)
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
            $command = new CancelStopSaleCommand(intval($request->get('id')));

            $response = $this->handler->handle($command);

            return $this->json(['cancelled' => $response->isCancelled()]);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
