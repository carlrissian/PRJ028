<?php

namespace App\Controller\Acriss;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Acriss\Application\FilterAcriss\FilterAcrissQuery;
use Distribution\Acriss\Application\FilterAcriss\FilterAcrissQueryHandler;

class FilterAcrissController extends AbstractController
{
    /**
     * @var FilterAcrissQueryHandler
     */
    private $handler;

    /**
     * @param FilterAcrissQueryHandler $handler
     */
    public function __construct(FilterAcrissQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $sortOptions = [
                "name" => "ACRISSCODE",
                "carClass" => "CARCLASSNAME",
                "acrissType" => "CARTYPENAME",
                "gearBox" => "GEARBOXTYPE",
                "motorizationType" => "MOTORTYPENAME",
                "commercialGroup" => "GROUPNAME",
                "carGroup" => "VEHICLEGROUPNAME",
                "status" => "ACRISSSTATUS",
                "default" => "CREATIONDATE",
                "undefined" => "CREATIONDATE",
            ];
            $sort = $sortOptions[$request->get('sort', 'default')];
            $defaultOrder = $sort === "CREATIONDATE" ? 'desc' : null;

            $query = new FilterAcrissQuery(
                $sort,
                $defaultOrder ?? $request->get('order', $defaultOrder),
                intval($request->get('offset', 0)),
                intval($request->get('limit', 50)),
                $request->get('commercialGorupIds') ? json_decode($request->get('commercialGorupIds')) : null,
                $request->get('carGroupIds') ? json_decode($request->get('carGroupIds')) : null,
                $request->get('carClassIds') ? json_decode($request->get('carClassIds')) : null,
                $request->get('acrissName'),
                $request->get('motorizationTypeIds') ? json_decode($request->get('motorizationTypeIds')) : null,
                $request->get('gearBoxIds') ? json_decode($request->get('gearBoxIds')) : null,
                $request->get('status') ? filter_var($request->get('status'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null
            );

            $response = $this->handler->handle($query);

            return $this->json(
                [
                    'total' => $response->getTotalRows(),
                    'rows' => $response->getRows(),
                ]
            );
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
