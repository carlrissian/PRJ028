<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterAssignedVehiclesMovement;

use Distribution\Movement\Domain\MovementVehicleLine;
use Distribution\Movement\Domain\VehicleFilter;
use Distribution\Movement\Domain\VehicleLine;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Movement\Domain\MovementCriteria;
use Distribution\Movement\Domain\MovementException;
use Distribution\Movement\Domain\MovementRepository;

class FilterAssignedVehiclesQueryHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param FilterAssignedVehiclesQuery $query
     * @param boolean $excel
     * @return FilterAssignedVehiclesResponse
     *
     * @throws MovementException
     */
    public function handle(FilterAssignedVehiclesQuery $query, bool $excel): FilterAssignedVehiclesResponse
    {
        /**
         * @var Movement $movement
         */
        $movement = $this->movementRepository->getById($query->getMovementId());
        if (empty($movement)) {
            throw new MovementException('Error getting movement');
        }

        $criteria = $this->setCriteria($query);
        [$vehicleLineCollection, $totalRows] = $this->movementRepository->getAssignedVehicles($movement->getId(), $criteria)->toArray();
        if (empty($vehicleLineCollection)) {
            throw new MovementException('Error getting vehicle collection');
        }


        $vehicleFilters = $movement->getVehicleFilterCollection()->toArray();
        $vehicleFiltersArray = [];
        foreach ($vehicleFilters as $vehicleFilter) {
            /**
             * @var VehicleFilter $vehicleFilter
             */
            if (!empty($vehicleFilter->getBrandCollection())) {
                $vehicleFiltersArray['brand'] = array_map(function ($brand) {
                    return $brand->getId();
                }, $vehicleFilter->getBrandCollection()->toArray());
            }
            if (!empty($vehicleFilter->getModelCollection())) {
                $vehicleFiltersArray['model'] = array_map(function ($model) {
                    return $model->getId();
                }, $vehicleFilter->getModelCollection()->toArray());
            }
            if (!empty($vehicleFilter->getCarGroupCollection())) {
                $vehicleFiltersArray['carGroup'] = array_map(function ($carGroup) {
                    return $carGroup->getId();
                }, $vehicleFilter->getCarGroupCollection()->toArray());
            }
            if (!is_null($vehicleFilter->getKilometersFrom())) {
                $vehicleFiltersArray['kilometersFrom'] = $vehicleFilter->getKilometersFrom();
            }
            if (!is_null($vehicleFilter->getKilometersTo())) {
                $vehicleFiltersArray['kilometersTo'] = $vehicleFilter->getKilometersTo();
            }
            if (!is_null($vehicleFilter->getRentingEndDateFrom())) {
                $vehicleFiltersArray['rentingEndDateFrom'] = $vehicleFilter->getRentingEndDateFrom();
            }
            if (!is_null($vehicleFilter->getRentingEndDateTo())) {
                $vehicleFiltersArray['rentingEndDateTo'] = $vehicleFilter->getRentingEndDateTo();
            }
            if (!empty($vehicleFilter->getSaleMethodCollection())) {
                $vehicleFiltersArray['saleMethod'] = array_map(function ($saleMethod) {
                    return $saleMethod->getId();
                }, $vehicleFilter->getSaleMethodCollection()->toArray());
            }
            if (!is_null($vehicleFilter->getCheckInDateFrom())) {
                $vehicleFiltersArray['checkInDate'] = $vehicleFilter->getCheckInDateFrom();
            }
            if (!is_null($vehicleFilter->isConnectedVehicle())) {
                $vehicleFiltersArray['connected'] = $vehicleFilter->isConnectedVehicle();
            }
            if (!is_null($vehicleFilter->getVehicleStatusCollection())) {
                $vehicleFiltersArray['vehicleStatus'] = array_map(function ($vehicleStatus) {
                    return $vehicleStatus->getId();
                }, $vehicleFilter->getVehicleStatusCollection()->toArray());
            }
        }

        $vehicleList = [];
        /**
         * @var VehicleLine $vehicleLine
         */
        foreach ($vehicleLineCollection as $vehicleLine) {
            $vehicle = $vehicleLine->getVehicle();

            $invalidKms = (isset($vehicleFiltersArray['kilometersFrom']) && $vehicle->getActualKms() < $vehicleFiltersArray['kilometersFrom']) ||
                (isset($vehicleFiltersArray['kilometersTo']) && $vehicle->getActualKms() > $vehicleFiltersArray['kilometersTo']);

            $invalidRentingEndDate = (isset($vehicleFiltersArray['rentingEndDateFrom']) && $vehicle->getRentingEndDate() < $vehicleFiltersArray['rentingEndDateFrom']) ||
                (isset($vehicleFiltersArray['rentingEndDateTo']) && $vehicle->getRentingEndDate() > $vehicleFiltersArray['rentingEndDateTo']);

            $invalidConnectedVehicle = isset($vehicleFiltersArray['connected']) && $vehicleFiltersArray['connected'] != $vehicle->isConnected();

            $invalidBrand = isset($vehicleFiltersArray['brand']) && count($vehicleFiltersArray['brand']) > 0 && !in_array($vehicle->getBrand()->getId(), $vehicleFiltersArray['brand'], true);
            $invalidModel = isset($vehicleFiltersArray['model']) && count($vehicleFiltersArray['model']) > 0 && !in_array($vehicle->getModel()->getId(), $vehicleFiltersArray['model'], true);
            $invalidCarGroup = isset($vehicleFiltersArray['carGroup']) && count($vehicleFiltersArray['carGroup']) > 0 && !in_array($vehicle->getCarGroup()->getId(), $vehicleFiltersArray['carGroup'], true);
            $invalidSaleMethod = isset($vehicleFiltersArray['saleMethod']) && count($vehicleFiltersArray['saleMethod']) > 0 && !in_array($vehicle->getSaleMethod()->getId(), $vehicleFiltersArray['saleMethod'], true);
            $invalidVehicleStatus = isset($vehicleFiltersArray['vehicleStatus']) && count($vehicleFiltersArray['vehicleStatus']) > 0 && !in_array($vehicle->getStatus()->getId(), $vehicleFiltersArray['vehicleStatus'], true);

            $vehicleList[] = [
                'id' => $vehicle->getId(),
                'licensePlate' => [
                    'name' => $vehicle->getLicensePlate(),
                    'error' =>  $invalidBrand || $invalidModel || $invalidCarGroup || $invalidSaleMethod || $invalidVehicleStatus || $invalidKms || $invalidRentingEndDate || $invalidConnectedVehicle,
                ],
                'vin' => $vehicle->getVin(),
                'brand' => [
                    'name' => $vehicle->getBrand() ? $vehicle->getBrand()->getName() : null,
                    'error' => $invalidBrand,
                ],
                'model' => [
                    'name' => $vehicle->getModel() ? $vehicle->getModel()->getName() : null,
                    'error' => $invalidModel,
                ],
                'carGroup' => [
                    'name' => $vehicle->getCarGroup() ? $vehicle->getCarGroup()->getName() : null,
                    'error' => $invalidCarGroup,
                ],
                'kilometers' => [
                    'name' => $vehicle->getActualKms(),
                    'error' => $invalidKms,
                ],
                'rentingEndDate' => [
                    'name' => $vehicle->getRentingEndDate(),
                    'error' => $invalidRentingEndDate,
                ],
                'saleMethod' => [
                    'name' => $vehicle->getSaleMethod() ? $vehicle->getSaleMethod()->getName() : null,
                    'error' => $invalidSaleMethod,
                ],
                'vehicleStatus' => [
                    'name' => $vehicle->getStatus() ? $vehicle->getStatus()->getName() : null,
                    'error' => $invalidVehicleStatus,
                ],
                'connectedVehicle' => [
                    'name' => $vehicle->isConnected(),
                    'error' => $invalidConnectedVehicle,
                ],
                'branch' => $vehicle->getBranch() ? $vehicle->getBranch()->getName() : null,
                'actualLoadDate' => $vehicleLine->getActualLoadDate(),
                'actualUnloadDate' => $vehicleLine->getActualUnLoadDate(),
                'initBlockDate' => $vehicle->getInitBlockDate(),
                'endBlockDate' => $vehicle->getEndBlockDate(),
                'vehicleMaintenanceEndDate' => $vehicleLine->getVehicleMaintenanceEndDate(),
                'checkInDueDate' => $vehicle->getCheckInDate(),
                'movementId' => $movement->getId(),
                'expectedLoadDate' => $movement->getExpectedLoadDate(),
                'expectedUnloadDate' => $movement->getExpectedUnloadDate(),
                'originLocationName' => $movement->getOriginLocation() ? $movement->getOriginLocation()->getName() : null,
                'destinationLocationName' => $movement->getDestinationLocation() ? $movement->getDestinationLocation()->getName() : null,
                'supplierName' => $movement->getSupplier() ? $movement->getSupplier()->getName() : null,
            ];
        }

        if ($excel) {
            $body = $this->createExcelArrayFormatter($vehicleList);
            $vehicleList = $body;
            $totalRows = count($body);
        }

        return new FilterAssignedVehiclesResponse($vehicleList, $totalRows);
    }

    /**
     * @param FilterAssignedVehiclesQuery $query
     * @return MovementCriteria
     */
    private function setCriteria(FilterAssignedVehiclesQuery $query): MovementCriteria
    {
        $filterCollection = new FilterCollection([]);

        $filterCollection->add(new Filter('ID', new FilterOperator(FilterOperator::EQUAL), $query->getMovementId()));

        $sortCollection = null;
        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        return new MovementCriteria($filterCollection, $pagination);
    }


    private function createExcelArrayFormatter(array $movementList): array
    {
        $movementExcel[] = [
            'Nº de movimiento',
            'Matrícula',
            'Bastidor',
            'Marca',
            'Modelo',
            'Grupo',
            'Kilómetros',
            'Fecha fin alquiler',
            'Método venta',
            'Vehículo conectado',
            'Estado vehículo',
            'Fecha fin contrato prevista',
            'Fecha carga prevista',
            'Fecha carga real',
            'Hora carga real',
            'Fecha descarga prevista',
            'Fecha descarga real',
            'Hora descarga real',
            'Fecha prevista salida taller',
            'Localización origen',
            'Localización destino',
            'Proveedor'
        ];


        foreach ($movementList as $vehicle) {
            $movementExcel[] = [
                $vehicle['movementId'],
                $vehicle['licensePlate']['name'],
                $vehicle['vin'],
                $vehicle['brand']['name'],
                $vehicle['model']['name'],
                $vehicle['carGroup']['name'],
                $vehicle['kilometers']['name'],
                $vehicle['rentingEndDate']['name'],
                $vehicle['saleMethod']['name'],
                empty($vehicle['connectedVehicle']['name']) ? (($vehicle['connectedVehicle']['name'] == 1) ? 'Sí' : 'No') : null,
                $vehicle['vehicleStatus']['name'],
                $vehicle['checkInDueDate'],
                $vehicle['expectedLoadDate'],
                $vehicle['actualLoadDate'] ? $vehicle['actualLoadDate']->__toString("d/m/Y") : null,
                $vehicle['actualLoadDate'] ? $vehicle['actualLoadDate']->__toString("H:i") : null,
                $vehicle['expectedUnloadDate'],
                $vehicle['actualUnloadDate'] ? $vehicle['actualUnloadDate']->__toString("d/m/Y") : null,
                $vehicle['actualUnloadDate'] ? $vehicle['actualUnloadDate']->__toString("H:i") : null,
                $vehicle['vehicleMaintenanceEndDate'],
                $vehicle['originLocationName'],
                $vehicle['destinationLocationName'],
                $vehicle['supplierName'],
            ];
        }

        return $movementExcel;
    }
}
