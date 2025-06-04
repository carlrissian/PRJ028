<?php

namespace App\Controller\CommercialGroup;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\CommercialGroup\Application\SelectListCommercialGroup\SelectListCommercialGroupQueryHandler;

class SelectListCommercialGroupController extends Controller
{
    /**
     * @var SelectListCommercialGroupQueryHandler
     */
    private SelectListCommercialGroupQueryHandler $handler;

    /**
     * @param SelectListCommercialGroupQueryHandler $handler
     */
    public function __construct(SelectListCommercialGroupQueryHandler $handler)
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
