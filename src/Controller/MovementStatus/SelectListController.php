<?php

namespace App\Controller\MovementStatus;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\MovementStatus\Application\Filter\FilterMovementStatusQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var FilterMovementStatusQueryHandler
     */
    private FilterMovementStatusQueryHandler $handler;

    /**
     * @param FilterMovementStatusQueryHandler $handler
     */
    public function __construct(FilterMovementStatusQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->handler->handle();

        return $this->json($response->getSelectList());
    }
}
