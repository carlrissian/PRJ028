<?php
declare(strict_types=1);

namespace App\Controller\CarGroup;

use App\Controller\Controller;
use Distribution\CarGroup\Application\FilterCarGroup\FilterCarGroupQuery;
use Distribution\CarGroup\Application\FilterCarGroup\FilterCarGroupQueryHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FilterCarGroupController extends Controller
{
    private FilterCarGroupQueryHandler $handler;
    public function __construct(FilterCarGroupQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $limit = (int) $request->get('limit');
        $offset = (int) $request->get('offset');

        $carGroupList = $request->get('carGroupId') ? json_decode( $request->get('carGroupId')) : null;
        $acrissName = $request->get('acrissName');
        $status = $request->get('status');

        $query = new FilterCarGroupQuery($limit, $offset, $carGroupList, $acrissName, $status);
        $response = $this->handler->handle($query);


        return $this->json([ 'rows' => $response->getCarGroupList(), 'total' => $response->getTotal() ] );
    }
}