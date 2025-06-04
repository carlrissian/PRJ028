<?php

namespace App\Controller\Brand;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Brand\Application\SelectList\SelectListBrandQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListBrandQueryHandler
     */
    private $handler;

    /**
     * @param SelectListBrandQueryHandler $handler
     */
    public function __construct(SelectListBrandQueryHandler $handler)
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
