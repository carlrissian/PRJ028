<?php

namespace App\Controller\MovementCategory;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\MovementCategory\Application\SelectList\SelectListMovementCategoryQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListMovementCategoryQueryHandler
     */
    private $handler;

    /**
     * @param SelectListMovementCategoryQueryHandler $handler
     */
    public function __construct(SelectListMovementCategoryQueryHandler $handler)
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
