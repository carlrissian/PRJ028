<?php

namespace App\Controller\State;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\State\Application\FilterState\FilterStateQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\State\Application\FilterState\FilterStateQueryHandler;

class FilterController extends AbstractController
{
    /**
     * @var FilterStateQueryHandler
     */
    private FilterStateQueryHandler $handler;

    /**
     * @param FilterStateQueryHandler $handler
     */
    public function __construct(FilterStateQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $query = new FilterStateQuery(
            $request->get('countryId') ? intval($request->get('countryId')) : null
        );

        $response = $this->handler->handle($query);

        return $this->json($response->getStateList());
    }
}
