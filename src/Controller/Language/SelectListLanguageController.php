<?php

namespace App\Controller\Language;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Language\Application\SelectList\SelectListLanguageQueryHandler;

class SelectListLanguageController extends AbstractController
{
    /**
     * @var SelectListLanguageQueryHandler
     */
    private $handler;

    /**
     * @param SelectListLanguageQueryHandler $handler
     */
    public function __construct(SelectListLanguageQueryHandler $handler)
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
