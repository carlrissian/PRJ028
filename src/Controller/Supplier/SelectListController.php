<?php

namespace App\Controller\Supplier;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Supplier\Application\SelectList\SelectListSupplierQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListSupplierQueryHandler
     */
    private $handler;

    /**
     * @param SelectListSupplierQueryHandler $handler
     */
    public function __construct(SelectListSupplierQueryHandler $handler)
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
