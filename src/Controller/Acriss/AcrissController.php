<?php

declare(strict_types=1);


namespace App\Controller\Acriss;

use App\Controller\Controller;
use Distribution\Acriss\Application\AssociateAcriss\AssociateAcrissCommand;
use Distribution\Acriss\Application\AssociateAcriss\AssociateAcrissCommandHandler;
use Distribution\Acriss\Application\CheckIsAcrissOnBooking\CheckIsAcrissOnBookingQuery;
use Distribution\Acriss\Application\CheckIsAcrissOnBooking\CheckIsAcrissOnBookingQueryHandler;
use Distribution\Acriss\Application\CreateAcriss\CreateAcrissQuery;
use Distribution\Acriss\Application\CreateAcriss\CreateAcrissQueryHandler;
use Distribution\Acriss\Application\FilterAcriss\FilterAcrissQuery;
use Distribution\Acriss\Application\FilterAcriss\FilterAcrissQueryHandler;
use Distribution\Acriss\Application\FilterAssociateAcriss\FilterAssociateQuery;
use Distribution\Acriss\Application\FilterAssociateAcriss\FilterAssociateQueryHandler;
use Distribution\Acriss\Application\GetAcrissToAssociate\GetAcrissToAssociateQuery;
use Distribution\Acriss\Application\GetAcrissToAssociate\GetAcrissToAssociateQueryHandler;
use Distribution\Acriss\Application\GetListFilters\GetListFiltersQueryHandler;
use Distribution\Acriss\Application\StoreAcriss\StoreAcrissCommandHandler;
use Distribution\Acriss\Application\StoreAcriss\StoreAcrissCommand;
use Distribution\Acriss\Domain\InvalidAcrissException;
use Distribution\CarGroup\Application\FilterCarGroup\FilterCarGroupQuery;
use Distribution\CarGroup\Application\FilterCarGroup\FilterCarGroupQueryHandler;
use Distribution\Shared\Domain\RepositoryException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AcrissController extends Controller
{
    public static string $FLASH_OK = 'success';
    public static string $FLASH_WARNING = 'warning';

    public static string $ACRISS_LIST_ROUTE = 'acriss.list';

    /**
     * @param Request $request
     * @param FilterAssociateQueryHandler $filterAcrissHandler
     * @return JsonResponse
     */
    public function associateFilter(Request $request, FilterAssociateQueryHandler $filterAcrissHandler): JsonResponse
    {
        $response = $filterAcrissHandler->handle(
            new FilterAssociateQuery(
                $request->get('limit') == '' ? null : $request->get('limit'),
                $request->get('offset') == '' ? null : $request->get('offset')
            )
        );

        return $this->json([
            'total' => $response->getTotalRows(),
            'rows' => $response->getAcrissArray()
        ]);
    }

    final public function getGroups(Request $request, FilterCarGroupQueryHandler $carGroupHandler): JsonResponse
    {
        // TODO revisar
        $response = $carGroupHandler->handle(new FilterCarGroupQuery(10, 0, $request->get('carClassId'), null, null));
        return $this->json([
            'carGroups' => $response->getCarGroupList()
        ]);
    }


    public function getAcrissToAssociate(Request $request, GetAcrissToAssociateQueryHandler $handler): JsonResponse
    {

        $acrissQuery = new GetAcrissToAssociateQuery(
            $request->get('acrissId')
        );
        $response = $handler->handle($acrissQuery);

        return $this->json([
            'response' => $response->getCollection()
        ]);
    }

    public function setAcrissToAssociate(Request $request, AssociateAcrissCommandHandler $handler): JsonResponse
    {

        $acrissQuery = new AssociateAcrissCommand(
            $request->get('acrissId'),
            $request->get('acrissToAssociate')
        );

        $response = $handler->handle($acrissQuery);

        return $this->json([
            'response' => 'ok'
        ]);
    }

    public function setAcrissToDisassociate(Request $request, AssociateAcrissCommandHandler $handler): JsonResponse
    {

        $acrissQuery = new AssociateAcrissCommand(
            $request->get('acrissId'),
            $request->get('acrissToDisassociate')
        );

        $response = $handler->handle($acrissQuery);

        return $this->json([
            'response' => 'ok'
        ]);
    }

    public function checkAcrissIsOnBooking(Request $request, CheckIsAcrissOnBookingQueryHandler $handler): JsonResponse
    {

        $response = $handler->handle(new CheckIsAcrissOnBookingQuery($request->get('acrissId')));
        return $this->json([
            'isAcrissOnBooking' => $response->getIsAcrissOnBooking()
        ]);
    }
}
