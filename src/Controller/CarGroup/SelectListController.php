<?php

namespace App\Controller\CarGroup;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\CarGroup\Application\SelectList\SelectListCarGroupQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListCarGroupQueryHandler
     */
    private $handler;

    /**
     * @param SelectListCarGroupQueryHandler $handler
     */
    public function __construct(SelectListCarGroupQueryHandler $handler)
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
