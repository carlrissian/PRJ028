<?php

namespace App\Controller\MotorizationType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\MotorizationType\Application\SelectList\SelectListMotorizationTypeQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListMotorizationTypeQueryHandler
     */
    private $handler;

    /**
     * @param SelectListMotorizationTypeQueryHandler $handler
     */
    public function __construct(SelectListMotorizationTypeQueryHandler $handler)
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
