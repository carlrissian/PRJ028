<?php

namespace App\Controller\LocationType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\LocationType\Application\SelectList\SelectListLocationTypeQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListLocationTypeQueryHandler
     */
    private $handler;

    /**
     * @param SelectListLocationTypeQueryHandler $handler
     */
    public function __construct(SelectListLocationTypeQueryHandler $handler)
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
