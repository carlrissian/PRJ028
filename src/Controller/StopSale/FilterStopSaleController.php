<?php

namespace App\Controller\StopSale;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Distribution\StopSale\Domain\StopSaleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\StopSale\Application\FilterStopSale\FilterStopSaleQuery;
use Distribution\StopSale\Application\FilterStopSale\FilterStopSaleQueryHandler;

class FilterStopSaleController extends AbstractController
{
    /**
     * @var FilterStopSaleQueryHandler
     */
    private $handler;

    /**
     * @param FilterStopSaleQueryHandler $handler
     */
    public function __construct(FilterStopSaleQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * 
     * @throws StopSaleException
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $sort = strtoupper($request->get('sort'));
            $order = strtoupper($request->get('order'));
            if (in_array($sort, [strtoupper('undefined'), null])) {
                $sort = 'CREATIONDATE';
                $order = 'DESC';
            }
           
            $query = new FilterStopSaleQuery(
                $sort,
                $order,
                $request->get('offset') ? intval($request->get('offset')) : null,
                $request->get('limit') ? intval($request->get('limit')) : null,
                $request->get('departmentsId') ? json_decode($request->get('departmentsId')) : null,
                is_numeric($request->get('stopSaleCategoryId')) ? intval($request->get('stopSaleCategoryId')) : null,
                $request->get('stopSaleInitDate'),
                $request->get('stopSaleEndDate'),
                $request->get('acrissId') ? json_decode($request->get('acrissId')) : null,
                $request->get('regionPickUpId') ? json_decode($request->get('regionPickUpId')) : null,
                $request->get('regionDropId') ? json_decode($request->get('regionDropId')) : null,
                $request->get('areaPickUpId') ? json_decode($request->get('areaPickUpId')) : null,
                $request->get('areaDropId') ? json_decode($request->get('areaDropId')) : null,
                $request->get('branchesPickUpId') ? json_decode($request->get('branchesPickUpId')) : null,
                $request->get('branchDropId') ? json_decode($request->get('branchDropId')) : null,
                $request->get('partnersId') ? json_decode($request->get('partnersId')) : null,
                $request->get('sellCodesId') ? json_decode($request->get('sellCodesId')) : null,
                $request->get('productsId') ? json_decode($request->get('productsId')) : null,
                $request->get('stopSaleTypeId') ? json_decode($request->get('stopSaleTypeId')) : null,
                is_numeric($request->get('stopSaleStatusId')) ? intval($request->get('stopSaleStatusId')) : null,
                filter_var($request->get('connectedVehicle'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
                $request->get('creationDateFrom'),
                $request->get('creationDateTo')
            );

            $response = $this->handler->handle($query);

            return $this->json($response->getStopSaleResponse());
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
