<?php

namespace App\Controller\BusinessUnit;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\BusinessUnit\Application\SelectList\SelectListBusinessUnitQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListBusinessUnitQueryHandler
     */
    private $handler;

    /**
     * @param SelectListBusinessUnitQueryHandler $handler
     */
    public function __construct(SelectListBusinessUnitQueryHandler $handler)
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
