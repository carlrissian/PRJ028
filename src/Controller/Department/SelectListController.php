<?php

namespace App\Controller\Department;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Department\Application\SelectList\SelectListDepartmentQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListDepartmentQueryHandler
     */
    private $handler;

    /**
     * @param SelectListDepartmentQueryHandler $handler
     */
    public function __construct(SelectListDepartmentQueryHandler $handler)
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
