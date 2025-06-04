<?php

namespace App\Controller\Damage;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Damage\Application\FilterDamage\FilterDamageQuery;
use Distribution\Damage\Application\FilterDamage\FilterDamageQueryHandler;

class FilterController extends AbstractController
{
    /**
     * @var FilterDamageQueryHandler
     */
    private FilterDamageQueryHandler $handler;

    /**
     * @param FilterDamageQueryHandler $handler
     */
    public function __construct(FilterDamageQueryHandler $handler)
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
            $query = new FilterDamageQuery(
                $request->get("vehicleId") ? intval($request->get("vehicleId")) : null,
                $request->get("vehiclePickupDate")
            );

            $response = $this->handler->handle($query);

            return $this->json($response->getDamageList());
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
