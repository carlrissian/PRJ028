<?php

namespace App\Controller\Model;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Model\Application\SelectList\SelectListModelQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListModelQueryHandler
     */
    private $handler;

    /**
     * @param SelectListModelQueryHandler $handler
     */
    public function __construct(SelectListModelQueryHandler $handler)
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
