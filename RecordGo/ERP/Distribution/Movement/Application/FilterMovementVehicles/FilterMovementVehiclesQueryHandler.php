<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterMovementVehicles;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Distribution\Movement\Domain\Movement;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\Movement\Domain\MovementCriteria;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Movement\Domain\MovementException;
use Distribution\Movement\Domain\MovementRepository;

class FilterMovementVehiclesQueryHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * FilterMovementQueryHandler constructor.
     *
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @throws MovementException
     */
    final public function handle(FilterMovementVehiclesQuery $query): FilterMovementVehiclesResponse
    {
        $filterCollection = $this->setCriteria($query);

        // Para obtener los datos del excel tenemos que quitar la paginacion, sino viene vacio, en el listado si tenemos la paginacion
        $movementCriteria = new MovementCriteria($filterCollection);

        $movementVehicleResponse = $this->movementRepository->getByVehicles($movementCriteria)->toArray();

        if (empty($movementVehicleResponse)) {
            throw new MovementException('Error getting movement vehicle collection');
        }

        $actualLoadDate = null;
        $actualUnloadDate = null;
        $movementVehicleList = [];

        /**
         * @var Movement $movement
         */
        foreach ($movementVehicleResponse as $movementVehicleArray) {
            foreach ($movementVehicleArray['VEHICLELINE'] as $vehicleLineArray) {
                $actualLoadDate = $vehicleLineArray['LOADDATE'] ? DateValueObject::createFromString($vehicleLineArray['LOADDATE'])->__toString() : null;
                $actualUnloadDate = $vehicleLineArray['UNLOADDATE'] ? DateValueObject::createFromString($vehicleLineArray['UNLOADDATE'])->__toString() : null;
                $movementVehicleList[] = [
                    'ID' => $movementVehicleArray['MOVEMENTID'],
                    'ORDERNUMBER' => $movementVehicleArray['ORDERNUMBER'],
                    'ORDERMOVEMENT' => $movementVehicleArray['ORDERMOVEMENT'],
                    'BUSINESSUNITNAME' => $movementVehicleArray['BUSINESSUNITNAME'],
                    'BUSINESSUNITARTICLENAME' => $movementVehicleArray['BUSINESSUNITARTICLENAME'],
                    'SUPPLIERNAME' => $movementVehicleArray['SUPPLIERNAME'],
                    'LICENSEPLATE' => $vehicleLineArray['LICENSEPLATE'],
                    'VIN' => $vehicleLineArray['VIN'],
                    'BRANDNAME' => $vehicleLineArray['BRANDNAME'],
                    'MODELNAME' => $vehicleLineArray['MODELNAME'],
                    'CARGROUPNAME' => $vehicleLineArray['CARGROUPNAME'],
                    'ORIGINLOCATIONNAME' => $movementVehicleArray['ORIGINLOCATIONNAME'],
                    'ORIGINDELEGATIONNAME' => $movementVehicleArray['ORIGINDELEGATIONNAME'],
                    'DESTINATIONLOCATIONNAME' => $movementVehicleArray['DESTINATIONLOCATIONNAME'],
                    'DESTINATIONDELEGATIONNAME' => $movementVehicleArray['DESTINATIONDELEGATIONNAME'],
                    'EXPECTEDLOADDATE' => $movementVehicleArray['EXPECTEDLOADDATE'] ? DateValueObject::createFromString($movementVehicleArray['EXPECTEDLOADDATE'])->__toString() : null,
                    'ACTUALLOADDATE' => $actualLoadDate,
                    'EXPECTEDUNLOADDATE' => $movementVehicleArray['EXPECTEDUNLOADDATE'] ? DateValueObject::createFromString($movementVehicleArray['EXPECTEDUNLOADDATE'])->__toString() : null,
                    'ACTUALUNLOADDATE' => $actualUnloadDate,
                    'MOVEMENTSTATUSNAME' => $movementVehicleArray['MOVEMENTSTATUSNAME'],
                    'CREATIONUSERNAME' => $movementVehicleArray['CREATIONUSERNAME'],
                    'CREATIONDATE' => $movementVehicleArray['CREATIONDATE'] ? DateTimeValueObject::createFromString($movementVehicleArray['CREATIONDATE'])->__toString() : null,
                ];
            }
        }
        $vehicle = $this->createArrayVehicleFormatter($movementVehicleList);
        $movementResponse['total'] = count($vehicle);
        $movementResponse['rows'] = $vehicle;


        return new FilterMovementVehiclesResponse($movementResponse);
    }



    /**
     * @param FilterMovementVehiclesQuery $query
     * @return FilterCollection
     */
    private function setCriteria(FilterMovementVehiclesQuery $query): FilterCollection
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getMovementCategory()) $filterCollection->add(new Filter('TRANSPORTCATIDIN', new FilterOperator(FilterOperator::IN), $query->getMovementCategory()));

        if ($query->getMovementTypeId()) $filterCollection->add(new Filter('TRANSPORTTYPEID', new FilterOperator(FilterOperator::EQUAL), $query->getMovementTypeId()));

        if ($query->getExtTransport() !== null) $filterCollection->add(new Filter('EXTTRANSPORT', new FilterOperator(FilterOperator::EQUAL), $query->getExtTransport() ? 1 : 0));

        if ($query->getMovementStatusId()) $filterCollection->add(new Filter('TRANSPORTSTATUSID', new FilterOperator(FilterOperator::IN), $query->getMovementStatusId()));

        if ($query->getId() && count($query->getId()) == 1) $filterCollection->add(new Filter('ID', new FilterOperator(FilterOperator::EQUAL), $query->getId()[0]));

        if ($query->getId() && count($query->getId()) > 1) $filterCollection->add(new Filter('IDIN', new FilterOperator(FilterOperator::IN), $query->getId()));

        if ($query->getOrderNumber() && count($query->getOrderNumber()) == 1) $filterCollection->add(new Filter('SAPPO', new FilterOperator(FilterOperator::EQUAL), $query->getOrderNumber()[0]));

        if ($query->getOrderNumber() && count($query->getOrderNumber()) > 1) $filterCollection->add(new Filter('ORDERNUMBERIN', new FilterOperator(FilterOperator::IN), $query->getOrderNumber()));

        if ($query->getLicensePlate()) $filterCollection->add(new Filter('LICENSEPLATE', new FilterOperator(FilterOperator::EQUAL), $query->getLicensePlate()));

        if ($query->getVin()) $filterCollection->add(new Filter('VIN', new FilterOperator(FilterOperator::EQUAL), $query->getVin()));

        if ($query->getBrandId()) $filterCollection->add(new Filter('BRANDIDIN', new FilterOperator(FilterOperator::IN), $query->getBrandId()));

        if ($query->getModelId()) $filterCollection->add(new Filter('MODELID', new FilterOperator(FilterOperator::IN), $query->getModelId()));

        if ($query->getSupplierCode()) $filterCollection->add(new Filter('TRANSPROVIDERID', new FilterOperator(FilterOperator::IN), $query->getSupplierCode()));

        if ($query->getOriginLocationId()) $filterCollection->add(new Filter('ORIGINLOCATIONID', new FilterOperator(FilterOperator::IN), $query->getOriginLocationId()));

        if ($query->getDestinationLocationId()) $filterCollection->add(new Filter('DESTINYLOCATIONID', new FilterOperator(FilterOperator::IN), $query->getDestinationLocationId()));

        if ($query->getOriginBranchId()) $filterCollection->add(new Filter('BRANCHORIGINIDS', new FilterOperator(FilterOperator::IN), $query->getOriginBranchId()));

        if ($query->getDestinationBranchId()) $filterCollection->add(new Filter('BRANCHDESTINATIONIDS', new FilterOperator(FilterOperator::IN), $query->getDestinationBranchId()));

        if ($query->getCheckOutDateFrom()) $filterCollection->add(new Filter('ACTUALLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCheckOutDateFrom())));

        if ($query->getCheckOutDateTo()) $filterCollection->add(new Filter('ACTUALLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCheckOutDateTo())));

        if ($query->getExpectedLoadDate()) $filterCollection->add(new Filter('ESTIMATEDDEPARTURE', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getExpectedLoadDate())));

        if ($query->getExpectedUnloadDate()) $filterCollection->add(new Filter('ESTIMATEDARRIVAL', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getExpectedUnloadDate())));
        /* */

        if ($query->getActualLoadDate()) $filterCollection->add(new Filter('LOADDATE', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), $query->getActualLoadDate()));

        if ($query->getActualUnloadDate()) $filterCollection->add(new Filter('UNLOADDATE', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), $query->getActualUnloadDate()));

        if ($query->getExpectedLoadDateFrom()) $filterCollection->add(new Filter('EXPECTEDLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getExpectedLoadDateFrom())));

        if ($query->getExpectedLoadDateTo()) $filterCollection->add(new Filter('EXPECTEDLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getExpectedLoadDateTo())));

        if ($query->getExpectedUnloadDateFrom()) $filterCollection->add(new Filter('EXPECTEDUNLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getExpectedUnloadDateFrom())));

        if ($query->getExpectedUnloadDateTo()) $filterCollection->add(new Filter('EXPECTEDUNLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getExpectedUnloadDateTo())));

        if ($query->getLoadDateFrom()) $filterCollection->add(new Filter('ACTUALLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getLoadDateFrom())));

        if ($query->getLoadDateTo()) $filterCollection->add(new Filter('ACTUALLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatStringDateTimeToOdataDate($query->getLoadDateTo())));

        if ($query->getUnloadDateFrom()) $filterCollection->add(new Filter('ACTUALUNLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getUnloadDateFrom())));

        if ($query->getUnloadDateTo()) $filterCollection->add(new Filter('ACTUALUNLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getUnloadDateTo())));

        if ($query->getBusinessUnitId()) $filterCollection->add(new Filter('BUSINESSUNITID', new FilterOperator(FilterOperator::IN), $query->getBusinessUnitId()));

        if ($query->getBusinessUnitArticleId()) $filterCollection->add(new Filter('TRANSSAPARTICLEID', new FilterOperator(FilterOperator::IN), $query->getBusinessUnitArticleId()));

        return $filterCollection;
    }


    private function createArrayVehicleFormatter(array $listMovements): array
    {
        $movementExcel = [];

        $movementExcel[] = [
            'Numero de movimiento',
            'Numero de pedido',
            'Unidades Negocio-Articulo',
            'Proveedor',
            'Matricula',
            'Bastidor',
            'Marca',
            'Modelo',
            'Grupo',
            'Localizacion origen',
            'Delegación origen',
            'Localizacion destino',
            'Delegación destino',
            'Fecha prevista carga',
            'Fecha real carga',
            'Fecha prevista descarga',
            'Fecha real descarga',
            'Estado del movimiento',
            'Usuario creacion',
            'Fecha creacion',
        ];
        foreach ($listMovements as $movement) {
            foreach ($movement['vehicle'] as $vehicle) {
                $movementExcel[] = [
                    $movement['orderMovement'],
                    $movement['orderNumber'],
                    $movement['businessUnitName'] . ' ' . $movement['businessUnitArticleName'],
                    $movement['supplierName'],
                    $vehicle['licensePlate'],
                    $vehicle['vin'],
                    $vehicle['brandName'],
                    $vehicle['modelName'],
                    $vehicle['carGroupName'],
                    $movement['originLocationName'],
                    $movement['originDelegationName'],
                    $movement['destinationLocationName'],
                    $movement['destinationDelegationName'],
                    $movement['expectedLoadDate'],
                    $vehicle['actualLoadDate'],
                    $movement['expectedUnloadDate'],
                    $vehicle['actualUnloadDate'],
                    $movement['movementStatusName'],
                    $movement['creationUserName'],
                    $movement['creationDate'],
                ];
            }
        }
        return $movementExcel;
    }
}
