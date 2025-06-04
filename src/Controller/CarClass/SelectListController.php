<?php

namespace App\Controller\CarClass;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\CarClass\Application\SelectList\SelectListCarClassQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListCarClassQueryHandler
     */
    private $handler;

    /**
     * @param SelectListCarClassQueryHandler $handler
     */
    public function __construct(SelectListCarClassQueryHandler $handler)
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
