<?php

namespace App\Controller\SaleMethod;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\SaleMethod\Application\SelectList\SelectListSaleMethodQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListSaleMethodQueryHandler
     */
    private $handler;

    /**
     * @param SelectListSaleMethodQueryHandler $handler
     */
    public function __construct(SelectListSaleMethodQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $response = $this->handler->handle();

        return $this->json($response->getSelectList());
    }
}
