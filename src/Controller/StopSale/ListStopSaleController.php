<?php

namespace App\Controller\StopSale;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Distribution\StopSale\Application\ListStopSale\ListStopSaleQuery;
use Distribution\StopSale\Application\ListStopSale\ListStopSaleQueryHandler;

class ListStopSaleController extends Controller
{
    /**
     * @var ListStopSaleQueryHandler
     */
    private $handler;

    /**
     * @param ListStopSaleQueryHandler $handler
     */
    public function __construct(ListStopSaleQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param string $stopSaleCategory
     * @param Request $request
     * @return Response
     */
    public function __invoke(string $stopSaleCategory, Request $request): Response
    {
        $categoryId = $request->get('stopSaleCategoryId');

        $response = $this->handler->handle(new ListStopSaleQuery($categoryId));

        return $this->render('pages/stopsale/list.html.twig', [
            'stopSaleCategoryId' => $categoryId,
            'stopSaleName' => $stopSaleCategory,
            'selectList' => $this->json($response->getSelectList())->getContent(),
        ]);
    }
}
