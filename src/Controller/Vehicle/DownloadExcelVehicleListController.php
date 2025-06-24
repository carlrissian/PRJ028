<?php

namespace App\Controller\Vehicle;

use App\Helpers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Distribution\Vehicle\Application\FilterVehicle\FilterVehicleQuery;
use Distribution\Vehicle\Application\FilterVehicle\FilterVehicleQueryHandler;
use Distribution\Vehicle\Domain\VehicleColumns;

class DownloadExcelVehicleListController extends AbstractController
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
     * @return StreamedResponse
     */
    public function __invoke(Request $request): StreamedResponse
    {
        try {
            $areasIn = $request->get('areasId') ?
                (is_numeric($request->get('areasId')) ?
                    [intval($request->get('areasId'))]
                    : json_decode($request->get('areasId', '[]'))
                ) : null;
             $branchsIn = $request->get('branchId') ?
                (is_numeric($request->get('branchId')) ?
                    [intval($request->get('branchId'))]
                    : json_decode($request->get('branchId', '[]'))
                ) : null;
            $locationIn = $request->get('locationId') ?
                (is_numeric($request->get('locationId')) ?
                    [intval($request->get('locationId'))]
                    : json_decode($request->get('locationId', '[]'))
                ) : null;
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

            $columns = $request->get('columns') ? json_decode($request->get('columns', '[]')) : null;

            /**
             * INFO: si en algún momento se decide mostrar columnas de tiempo en frontend, comentar esta funcionalidad
             * Esto provocaría que las columnas de tiempo se repitan en el excel
             * Cambiar $formattedColumns por $columns
             */
            $formattedColumns = [];
            foreach ($columns as $column) {
                if (strpos($column, 'Date') !== false) {
                    $timeColumn = str_replace('Date', 'Time', $column);
                    $formattedColumns[] = $column;
                    if (VehicleColumns::keyExists($timeColumn)) $formattedColumns[] = $timeColumn;
                } else {
                    $formattedColumns[] = $column;
                }
            }
            /* */
            $providerIn = $request->get('providerId') ?
            (is_numeric($request->get('providerId')) ?
                [intval($request->get('providerId'))]
                : json_decode($request->get('providerId', '[]'))
            ) : null;
            

            $query = new FilterVehicleQuery(
                null,
                null,
                null,
                null,
                null,
                $areasIn,
                $branchsIn,
                $locationIn,
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
                null,
                null,
                null,
                null,
                $request->get('actualUnloadDateFrom'),
                $request->get('actualUnloadDateTo'),
                $request->get('actualLoadDateFrom'),
                $request->get('actualLoadDateTo'),
                $vehicleTypeIn,
                $connectedVehicleIn,
                $formattedColumns,
                $request->get('cleanVehicle') ? intval($request->get('cleanVehicle')) : null

            );

            $response = $this->handler->handle($query, true);

            // Formateo de nombres de columnas
            $cols = VehicleColumns::getAllColumns();
            $headerColumns = array_map(function ($col) {
                return $col['name'];
            }, array_filter($cols, function ($col) use ($formattedColumns) {
                return in_array($col['id'], $formattedColumns);
            }));


            return Helpers::exportCsv(
                $response->getRows(),
                $headerColumns,
                'vehicle_list.csv'
            );
        } catch (\Exception $e) {
            return $this->json($e->getMessage());
        }
    }
}
