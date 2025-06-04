<?php

namespace App\Controller\StopSale;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Distribution\StopSale\Application\CreateStopSale\CreateStopSaleQuery;
use Distribution\StopSale\Application\CreateStopSale\CreateStopSaleQueryHandler;

class CreateStopSaleController extends Controller
{
    /**
     * @var CreateStopSaleQueryHandler
     */
    private $handler;

    /**
     * @param CreateStopSaleQueryHandler $handler
     */
    public function __construct(CreateStopSaleQueryHandler $handler)
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

        $response = $this->handler->handle(new CreateStopSaleQuery($categoryId));

        return $this->render('pages/stopsale/create.html.twig', [
            'stopSaleCategoryId' => $categoryId,
            'stopSaleName' => $stopSaleCategory,
            'selectList' => $this->json($response->getSelectList())->getContent(),
        ]);
    }
}
