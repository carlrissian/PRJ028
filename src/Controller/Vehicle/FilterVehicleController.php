<?php

namespace App\Controller\Vehicle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Vehicle\Application\FilterVehicle\FilterVehicleQuery;
use Distribution\Vehicle\Application\FilterVehicle\FilterVehicleQueryHandler;
use Distribution\Vehicle\Domain\VehicleColumns;

class FilterVehicleController extends AbstractController
{
    /**
     * @var FilterVehicleQueryHandler
     */
    private $handler;

    /**
     * @param FilterVehicleQueryHandler $handler
     */
    public function __construct(FilterVehicleQueryHandler $handler)
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
            $providerIn = $request->get('providerId') ?
                (is_numeric($request->get('providerId')) ?
                    [intval($request->get('providerId'))]
                    : json_decode($request->get('providerId', '[]'))
                ) : null;

            $purchaseMethodIn = $request->get('purchaseMethodId') ?
                (is_numeric($request->get('purchaseMethodId')) ?
                    [intval($request->get('purchaseMethodId'))]
                    : json_decode($request->get('purchaseMethodId', '[]'))
                ) : null;

            $saleMethodIn = $request->get('saleMethodId') ?
                (is_numeric($request->get('saleMethodId')) ?
                    [intval($request->get('saleMethodId'))]
                    : json_decode($request->get('saleMethodId', '[]'))
                ) : null;

            $carClassIn = $request->get('carClassId') ?
                (is_numeric($request->get('carClassId')) ?
                    [intval($request->get('carClassId'))]
                    : json_decode($request->get('carClassId', '[]'))
                ) : null;

            $carGroupIn = $request->get('carGroupId') ?
                (is_numeric($request->get('carGroupId')) ?
                    [intval($request->get('carGroupId'))]
                    : json_decode($request->get('carGroupId', '[]'))
                ) : null;

            $acrissIn = $request->get('acrissId') ?
                (is_numeric($request->get('acrissId')) ?
                    [intval($request->get('acrissId'))]
                    : json_decode($request->get('acrissId', '[]'))
                ) : null;

            $motorizationTypeIn = $request->get('motorizationTypeId') ?
                (is_numeric($request->get('motorizationTypeId')) ?
                    [intval($request->get('motorizationTypeId'))]
                    : json_decode($request->get('motorizationTypeId', '[]'))
                ) : null;

            $gearBoxIn = $request->get('gearBoxId') ?
                (is_numeric($request->get('gearBoxId')) ?
                    [intval($request->get('gearBoxId'))]
                    : json_decode($request->get('gearBoxId', '[]'))
                ) : null;

            $vehicleStatusIn = $request->get('vehicleStatusId') ?
                (is_numeric($request->get('vehicleStatusId')) ?
                    [intval($request->get('vehicleStatusId'))]
                    : json_decode($request->get('vehicleStatusId', '[]'))
                ) : null;

            $vehicleTypeIn = $request->get('vehicleTypeId') ?
                (is_numeric($request->get('vehicleTypeId')) ?
                    [intval($request->get('vehicleTypeId'))]
                    : json_decode($request->get('vehicleTypeId', '[]'))
                ) : null;

            $connectedVehicleIn = $request->get('connectedVehicle') ?
                (is_numeric($request->get('connectedVehicle')) ?
                    [intval($request->get('connectedVehicle'))]
                    : json_decode($request->get('connectedVehicle', '[]'))
                ) : null;

            $sortOptions = VehicleColumns::getSortOptions();
            $sortOptions['default'] = 'CREATIONDATE';
            $sortOptions['undefined'] = 'CREATIONDATE';


            $query = new FilterVehicleQuery(
                intval($request->get('limit', 10)),
                intval($request->get('offset', 0)),
                $sortOptions[$request->get('sort', 'default')],
                $request->get('order'),
                $request->get('regionId') ? intval($request->get('regionId')) : null,
                $request->get('areaId') ? intval($request->get('areaId')) : null,
                $request->get('branchId') ? intval($request->get('branchId')) : null,
                $request->get('locationId') ? intval($request->get('locationId')) : null,
                $request->get('brandId') ? intval($request->get('brandId')) : null,
                $request->get('modelId') ? intval($request->get('modelId')) : null,
                $request->get('trimId') ? intval($request->get('trimId')) : null,
                $providerIn,
                $purchaseMethodIn,
                $saleMethodIn,
                $carClassIn,
                $carGroupIn,
                $acrissIn,
                $motorizationTypeIn,
                $gearBoxIn,
                $vehicleStatusIn,
                $request->get('kmFrom') ? intval($request->get('kmFrom')) : null,
                $request->get('kmTo') ? intval($request->get('kmTo')) : null,
                $request->get('deliverynDateFrom'),
                $request->get('deliverynDateTo'),
                $request->get('firstRentDateFrom'),
                $request->get('firstRentDateTo'),
                $request->get('rentingEndDateFrom'),
                $request->get('rentingEndDateTo'),
                $request->get('byeByeDateFrom'),
                $request->get('byeByeDateTo'),
                $request->get('logistic') ? intval($request->get('logistic')) : null,
                $request->get('assumedCostBy') ? intval($request->get('assumedCostBy')) : null,
                $request->get('returnDateFrom'),
                $request->get('returnDateTo'),
                $request->get('creationDateFrom'),
                $request->get('creationDateTo'),
                $request->get('registrationDateFrom'),
                $request->get('registrationDateTo'),
                $request->get('startBlockageDateFrom'),
                $request->get('startBlockageDateTo'),
                $request->get('endBlockageDateFrom'),
                $request->get('endBlockageDateTo'),
                $request->get('actualUnloadDateFrom'),
                $request->get('actualUnloadDateTo'),
                $request->get('actualLoadDateFrom'),
                $request->get('actualLoadDateTo'),
                $vehicleTypeIn,
                $connectedVehicleIn
            );

            $response = $this->handler->handle($query);
        } catch (\Exception $e) {
            return $this->json($e->getMessage());
        }

        return $this->json(
            [
                'total' => $response->getTotalRows(),
                'rows' => $response->getRows(),
            ]
        );
    }
}
