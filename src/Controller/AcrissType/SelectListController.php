<?php

namespace App\Controller\AcrissType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\AcrissType\Application\SelectList\SelectListAcrissTypeQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListAcrissTypeQueryHandler
     */
    private $handler;

    /**
     * @param SelectListAcrissTypeQueryHandler $handler
     */
    public function __construct(SelectListAcrissTypeQueryHandler $handler)
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
