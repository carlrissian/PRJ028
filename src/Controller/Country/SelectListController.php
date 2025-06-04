<?php

namespace App\Controller\Country;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Country\Application\SelectList\SelectListCountryQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListCountryQueryHandler
     */
    private $handler;

    /**
     * @param SelectListCountryQueryHandler $handler
     */
    public function __construct(SelectListCountryQueryHandler $handler)
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
