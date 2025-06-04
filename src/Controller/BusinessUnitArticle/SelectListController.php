<?php

namespace App\Controller\BusinessUnitArticle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\BusinessUnitArticle\Application\SelectList\SelectListBusinessUnitArticleQuery;
use Distribution\BusinessUnitArticle\Application\SelectList\SelectListBusinessUnitArticleQueryHandler;

class SelectListController extends AbstractController
{
    /**
     * @var SelectListBusinessUnitArticleQueryHandler
     */
    private $handler;

    /**
     * @param SelectListBusinessUnitArticleQueryHandler $handler
     */
    public function __construct(SelectListBusinessUnitArticleQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->handler->handle(new SelectListBusinessUnitArticleQuery(
            $request->get('movementTypeId')
        ));

        return $this->json($response->getSelectList());
    }
}
