<?php

namespace App\Controller\GearBox;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\GearBox\Application\SelectList\SelectListGearBoxQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListGearBoxQueryHandler
     */
    private $handler;

    /**
     * @param SelectListGearBoxQueryHandler $handler
     */
    public function __construct(SelectListGearBoxQueryHandler $handler)
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
