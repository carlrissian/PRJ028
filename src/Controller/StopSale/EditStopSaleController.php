<?php

namespace App\Controller\StopSale;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Distribution\StopSale\Application\EditStopSale\EditStopSaleQuery;
use Distribution\StopSale\Application\EditStopSale\EditStopSaleQueryHandler;

class EditStopSaleController extends Controller
{
    /**
     * @var EditStopSaleQueryHandler
     */
    private $handler;

    /**
     * @param EditStopSaleQueryHandler $handler
     */
    public function __construct(EditStopSaleQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        $response = $this->handler->handle(new EditStopSaleQuery($id));

        return $this->render('pages/stopsale/edit.html.twig', [
            'stopSaleCategoryId' => $response->getStopSaleCategoryId(),
            'selectList' => $this->json($response->getSelectList())->getContent(),
            'stopSale' => $this->json($response->getStopSale())->getContent(),
        ]);
    }
}
