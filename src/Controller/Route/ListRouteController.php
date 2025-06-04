<?php

namespace App\Controller\Route;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Route\Application\ListRoute\ListRouteQueryHandler;

class ListRouteController extends Controller
{
    /**
     * @var ListRouteQueryHandler
     */
    private ListRouteQueryHandler $handler;

    /**
     * @param ListRouteQueryHandler $handler
     */
    public function __construct(ListRouteQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        $response = $this->handler->handle();

        return $this->render('pages/route/list.html.twig', [
            'selectList' => $this->json($response->getSelectList())->getContent(),
        ]);
    }
}
