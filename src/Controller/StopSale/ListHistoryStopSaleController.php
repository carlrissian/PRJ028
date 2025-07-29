<?php

namespace App\Controller\StopSale;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Distribution\StopSale\Application\ListHistoryStopSale\ListHistoryStopSaleQuery;
use Distribution\StopSale\Application\ListHistoryStopSale\ListHistoryStopSaleQueryHandler;

final class ListHistoryStopSaleController extends Controller
{
    /**
     * @var ListHistoryStopSaleQueryHandler
     */
    private $handler;

    /**
     * @param ListHistoryStopSaleQueryHandler $handler
     */
    public function __construct(ListHistoryStopSaleQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        $response = $this->handler->handle(new ListHistoryStopSaleQuery($id));
        return $this->json(
            [
                'total' => $response->getTotalRows(),
                'rows' => $response->getRows(),
            ]
        );
    }
}
