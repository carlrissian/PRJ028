<?php

namespace Distribution\Movement\Application\FilterVehicleToAssign;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\OperationResponse;
use Distribution\Vehicle\Domain\Vehicle;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Symfony\Component\HttpFoundation\Response;
use Distribution\Vehicle\Domain\VehicleRepository;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\Vehicle\Domain\VehicleGetByResponse;
use Distribution\Vehicle\Domain\VehicleToAssignCriteria;
use Distribution\Vehicle\Domain\VehicleNotFoundException;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

class FilterVehicleToAssignQueryHandler
{
    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * FilterVehicleQueryHandler constructor.
     * 
     * @param VehicleRepository $vehicleRepository
     * @param MovementRepository $movementRepository
     */
    public function __construct(
        VehicleRepository $vehicleRepository,
        MovementRepository $movementRepository
    ) {
        $this->vehicleRepository = $vehicleRepository;
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param FilterVehicleToAssignQuery $query
     * @param boolean $excel
     * @return FilterVehicleResponse
     * @throws VehicleNotFoundException
     */
    public function handle(FilterVehicleToAssignQuery $query, bool $excel): FilterVehicleToAssignResponse
    {
        $response = $this->vehicleRepository->getVehiclesToAssignBy($this->setCriteria($query));
        /**
         * @var VehicleGetByResponse $response
         */
        if ($response instanceof VehicleGetByResponse) {
            [$vehicleCollection, $totalRows] = $response->toArray();

            if (empty($vehicleCollection)) {
                throw new VehicleNotFoundException('Error getting vehicle collection', []);
            }

            $vehicleList = [];
            /**
             * @var Vehicle $vehicle
             */
            foreach ($vehicleCollection as $vehicle) {
                $vehicleList[] = [
                    'id' => $vehicle->getId(),
                    'licensePlate' => $vehicle->getLicensePlate(),
                    'vin' => $vehicle->getVin(),
                    'brand' => $vehicle->getBrand() ? $vehicle->getBrand()->getName() : null,
                    'model' => $vehicle->getModel() ? $vehicle->getModel()->getName() : null,
                    'carGroup' => $vehicle->getVehicleGroup() ? $vehicle->getVehicleGroup()->getName() : null,
                    'branch' => $vehicle->getBranch() ? $vehicle->getBranch()->getName() : null,
                    'kilometers' => $vehicle->getActualKms(),
                    'rentingEndDate' => $vehicle->getRentingEndDate(),
                    'saleMethod' => $vehicle->getSaleMethod() ? $vehicle->getSaleMethod()->getName() : null,
                    'vehicleStatus' => $vehicle->getStatus() ? [
                        'id' => $vehicle->getStatus()->getId(),
                        'name' => $vehicle->getStatus()->getName()
                    ] : null,
                    'connectedVehicle' => $vehicle->isConnected(),
                    'raDropOffDate' => $vehicle->getRentalAgreementDropOffDate(),
                    'initBlockDate' => $vehicle->getInitBlockageDate(),
                    'endBlockDate' => $vehicle->getEndBlockageDate(),
                    // 'vehicleMaintenanceEndDate' => $vehicle->getVehicleMaintenanceEndDate(), 
                    'actualBattery' => $vehicle->getBatteryActual(),
                    'actualOctaves' => $vehicle->getTankActualOctaves(),
                ];
            }

            return new FilterVehicleToAssignResponse($excel ? $this->formatterExcel($vehicleList) : $vehicleList, $totalRows, true, Response::HTTP_OK);
        }

        /**
         * @var OperationResponse $response
         */
        if ($response instanceof OperationResponse) {
            return new FilterVehicleToAssignResponse([], 0, $response->wasSuccess(), $response->getCode(), $response->getMessage());
        }
    }


    /**
     * @param FilterVehicleToAssignQuery $query
     * @return VehicleToAssignCriteria
     */
    private function setCriteria(FilterVehicleToAssignQuery $query): VehicleToAssignCriteria
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getMovementId())  $filterCollection->add(new Filter('MOVEMENTID', new FilterOperator(FilterOperator::EQUAL),  $query->getMovementId()));

        if ($query->getMovementTypeId())  $filterCollection->add(new Filter('MOVEMENTTYPEID', new FilterOperator(FilterOperator::EQUAL),  $query->getMovementTypeId()));

        if ($query->getLocationId())  $filterCollection->add(new Filter('LOCATIONID', new FilterOperator(FilterOperator::EQUAL),  $query->getLocationId()));

        if ($query->getVehicleTypeId()) $filterCollection->add(new Filter('VEHICLETYPEARRAY', new FilterOperator(FilterOperator::IN),  $query->getVehicleTypeId()));

        if ($query->getBrandId()) $filterCollection->add(new Filter('BRANDARRAY', new FilterOperator(FilterOperator::IN), $query->getBrandId()));

        if ($query->getModelId()) $filterCollection->add(new Filter('MODELARRAY', new FilterOperator(FilterOperator::IN), $query->getModelId()));

        if ($query->getCarGroupId()) $filterCollection->add(new Filter('CARGROUPARRAY', new FilterOperator(FilterOperator::IN), $query->getCarGroupId()));

        if ($query->getKilometerFrom()) $filterCollection->add(new Filter('KMFROM', new FilterOperator(FilterOperator::EQUAL), $query->getKilometerFrom()));

        if ($query->getKilometerTo()) $filterCollection->add(new Filter('KMTO', new FilterOperator(FilterOperator::EQUAL), $query->getKilometerTo()));

        if ($query->getRentingEndDateFrom()) $filterCollection->add(new Filter('RENTINGENDDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getRentingEndDateFrom())));

        if ($query->getRentingEndDateTo()) $filterCollection->add(new Filter('RENTINGENDDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getRentingEndDateTo())));

        if ($query->getResaleCode()) $filterCollection->add(new Filter('RESALECODEARRAY', new FilterOperator(FilterOperator::IN), $query->getResaleCode()));

        if ($query->getCheckInDateFrom()) $filterCollection->add(new Filter('CHECKINDATEFROM', new FilterOperator(FilterOperator::EQUAL), Utils::formatStringDateTimeToOdataDate($query->getCheckInDateFrom())));

        if ($query->getVehicleStatus()) $filterCollection->add(new Filter('VEHICLESTATUSARRAY', new FilterOperator(FilterOperator::IN), $query->getVehicleStatus()));

        if ($query->getConnectedVehicle()) $filterCollection->add(new Filter('CONNECTEDVEHICLE', new FilterOperator(FilterOperator::EQUAL), $query->getConnectedVehicle()));

        // localizacion origen/destino del movimiento
        if ($query->getMovementId()) {
            $movement = $this->movementRepository->getById($query->getMovementId());
            $originLocationId = [];
            if ($movement->getOriginLocation()) {
                $originLocationId[] = $movement->getOriginLocation()->getId();
            }
            if ($movement->getOriginExternalLocation()) {
                $originLocationId[] = $movement->getOriginExternalLocation()->getId();
            }
            if ($movement->getDestinationExternalLocation()) {
                $originLocationId[] = $movement->getDestinationExternalLocation()->getId();
            }

            if (!empty($originLocationId)) {
                $originLocationId = array_unique($originLocationId);
                if (count($originLocationId) == 1) {
                    $filterCollection->add(new Filter('LOCATIONID', new FilterOperator(FilterOperator::EQUAL), $originLocationId[0]));
                } else {
                    $filterCollection->add(new Filter('LOCATIONIDIN', new FilterOperator(FilterOperator::IN), $originLocationId));
                }
            }

            if ($movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('MOVEMENTTYPE_OPERATIONS'))) {
                $expectedLoadDateFormatted = Utils::formatStringDateTimeToOdataDate($movement->getExpectedLoadDate()->__toString());
            
                // Este filtro aplica solo a ON_RENT. El repositorio ya gestiona que se aplique a ese estado.
                $filterCollection->add(new Filter(
                    'rentingEndDateTo',
                    new FilterOperator(FilterOperator::LESS_EQUAL_THAN),
                    $expectedLoadDateFormatted
                ));
            }
            
        }

        $sortCollection = null;
        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        return new VehicleToAssignCriteria($filterCollection, $pagination);
    }

    /**
     * @param array $movementList
     * @return array
     */
    private function formatterExcel(array $movementList): array
    {
        $movementExcel[] = [
            'Matricula',
            'Bastidor',
            'Marca',
            'Modelo',
            'Grupo',
            'Kilometros',
            'Fecha fin alquiler',
            'Método de venta',
            'Estado vehículo',
            'Vehiculo conectado',
            'Fecha fin contrato prevista',
            'Fecha inicio Bloqueo',
            'Fecha fin Bloqueo',
            'Fecha prevista salida taller',
        ];

        foreach ($movementList as $vehicle) {
            $movementExcel[] = [
                $vehicle['licensePlate'],
                $vehicle['vin'],
                $vehicle['brand'],
                $vehicle['model'],
                $vehicle['carGroup'],
                $vehicle['kilometers'],
                $vehicle['rentingEndDate'],
                $vehicle['saleMethod'],
                $vehicle['vehicleStatus']['name'] ?? null,
                $vehicle['connectedVehicle'] ? 'Si' : 'No',
                $vehicle['checkInDueDate'],
                $vehicle['initBlockDate'],
                $vehicle['endBlockDate'],
                $vehicle['vehicleMaintenanceEndDate'] ?? null,

            ];
        }

        return $movementExcel;
    }
}
