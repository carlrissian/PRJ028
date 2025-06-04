<?php

namespace App\Controller\Branch;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Branch\Application\SelectList\SelectListBranchQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListBranchQueryHandler
     */
    private $handler;

    /**
     * @param SelectListBranchQueryHandler $handler
     */
    public function __construct(SelectListBranchQueryHandler $handler)
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
