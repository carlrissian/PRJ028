<?php

declare(strict_types=1);

namespace App\Controller\Location;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\Location\Application\Filter\FilterLocationQuery;
use Distribution\Location\Application\Details\DetailsLocationQuery;
use Distribution\Location\Application\Filter\FilterLocationQueryHandler;
use Distribution\Location\Application\Details\DetailsLocationQueryHandler;

class LocationController extends Controller
{
    /**
     * @return Response
     */
    final public function list(): Response
    {
        return $this->render('pages/location/list.html.twig');
    }

    /**
     * @param int $id
     * @param DetailsLocationQueryHandler $handler
     * @return JsonResponse
     */
    final public function details(int $id, DetailsLocationQueryHandler $handler): JsonResponse
    {
        $response = $handler->handle(new DetailsLocationQuery($id));
        // return $this->json($response->getLocation());
        return $this->json($response);
    }

    /**
     * @param Request $request
     * @param FilterLocationQueryHandler $handler
     * @return JsonResponse
     */
    final public function internalFilter(Request $request, FilterLocationQueryHandler $handler): JsonResponse
    {
        $query = new FilterLocationQuery(
            intval($request->get('limit')),
            intval($request->get('offset')),
            $request->get('sort'),
            $request->get('order'),
            false
        );

        $response = $handler->handle($query);

        return $this->json(
            [
                'rows' => $response->getRows(),
                'total' => $response->getTotalRows(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param FilterLocationQueryHandler $handler
     * @return JsonResponse
     */
    final public function externalFilter(Request $request, FilterLocationQueryHandler $handler): JsonResponse
    {
        $query = new FilterLocationQuery(
            intval($request->get('limit')),
            intval($request->get('offset')),
            $request->get('sort'),
            $request->get('order'),
            true
        );

        $response = $handler->handle($query);

        return $this->json(
            [
                'rows' => $response->getRows(),
                'total' => $response->getTotalRows(),
            ]
        );
    }
}
