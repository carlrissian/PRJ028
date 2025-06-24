<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\FilterVehicle;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use Distribution\Vehicle\Domain\Vehicle;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use Distribution\Vehicle\Domain\VehicleCriteria;
use Distribution\Vehicle\Domain\VehicleRepository;

class FilterVehicleQueryHandler
{
    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * GetVehicleQueryHandler constructor.
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @param FilterVehicleQuery $query
     * @param boolean $excel
     * @return FilterVehicleResponse
     */
    public function handle(FilterVehicleQuery $query, bool $excel = false): FilterVehicleResponse
    {
        $criteria = $this->setCriteria($query);
        [$vehicleCollection, $totalRows] = $this->vehicleRepository->getBy($criteria)->toArray();

        $vehicleList = [];
        foreach ($vehicleCollection as $vehicle) {
            /**
             * @var Vehicle $vehicle
             */
            $vehicleList[] = [
                'id' => $vehicle->getId(),
                'licensePlate' => $vehicle->getLicensePlate(),
                'vin' => $vehicle->getVin(),
                'brand' => ($vehicle->getBrand() !== null) ? $vehicle->getBrand()->getName() : null,
                'model' => ($vehicle->getModel() !== null) ? $vehicle->getModel()->getName() : null,
                'trim' => ($vehicle->getTrim() !== null) ? $vehicle->getTrim()->getName() : null,
                'acriss' => ($vehicle->getAcriss() !== null) ? $vehicle->getAcriss()->getName() : null,
                'carGroup' => ($vehicle->getVehicleGroup() !== null) ? $vehicle->getVehicleGroup()->getName() : null,
                'carClass' => ($vehicle->getCarClass() !== null) ? $vehicle->getCarClass()->getName() : null,
                'commercialGroup' => ($vehicle->getCommercialGroup() !== null) ? $vehicle->getCommercialGroup()->getName() : null,
                'region' => ($vehicle->getRegion() !== null) ? $vehicle->getRegion()->getName() : null,
                'area' => ($vehicle->getArea() !== null) ? $vehicle->getArea()->getName() : null,
                'branch' => ($vehicle->getBranch() !== null) ? $vehicle->getBranch()->getName() : null,
                'location' => ($vehicle->getLocation() !== null) ? $vehicle->getLocation()->getName() : null,
                'vehicleStatus' => ($vehicle->getStatus()) ? $vehicle->getStatus()->getName() : null,
                'kilometers' => $vehicle->getActualKms(),
                'provider' => $vehicle->getSupplier() ? $vehicle->getSupplier()->getName() : null,
                'purchaseMethod' => ($vehicle->getPurchaseMethod()) ? $vehicle->getPurchaseMethod()->getName() : null,
                'purchaseType' => ($vehicle->getPurchaseType()) ? $vehicle->getPurchaseType()->getName() : null,
                'motorizationType' => ($vehicle->getMotorizationType()) ? $vehicle->getMotorizationType()->getName() : null,
                'transmission' => ($vehicle->getGearBox()) ? $vehicle->getGearBox()->getName() : null,
                'vehicleType' => ($vehicle->getVehicleType()) ? $vehicle->getVehicleType()->getName() : null,
                'connected' => ($vehicle->isConnected() !== null) ? $vehicle->isConnected() : null,
                'firstRegistrationDate' => ($vehicle->getFirstRegistrationDate()) ? $vehicle->getFirstRegistrationDate()->__toString('d/m/Y') : null, // TODO ELIMINAR ESTE CAMPO, ES EL MISMO QUE REGISTRATIONDATE
                'firstRegistrationTime' => ($vehicle->getFirstRegistrationDate()) ? $vehicle->getFirstRegistrationDate()->__toString('H:i') : null, // TODO ELIMINAR ESTE CAMPO, ES EL MISMO QUE REGISTRATIONDATE
                'registrationDate' => ($vehicle->getFirstRegistrationDate()) ? $vehicle->getFirstRegistrationDate()->__toString('d/m/Y') : null,
                'registrationTime' => ($vehicle->getFirstRegistrationDate()) ? $vehicle->getFirstRegistrationDate()->__toString('H:i') : null,
                'deliveryDate' => ($vehicle->getDeliveryConfirmationDate()) ? $vehicle->getDeliveryConfirmationDate()->__toString('d/m/Y') : null,
                'deliveryTime' => ($vehicle->getDeliveryConfirmationDate()) ? $vehicle->getDeliveryConfirmationDate()->__toString('H:i') : null,
                'returnDate' => ($vehicle->getReturnDate()) ? $vehicle->getReturnDate()->__toString('d/m/Y') : null,
                'returnTime' => ($vehicle->getReturnDate()) ? $vehicle->getReturnDate()->__toString('H:i') : null,
                'firstRentDate' => ($vehicle->getFirstRentDate()) ? $vehicle->getFirstRentDate()->__toString('d/m/Y') : null,
                'firstRentTime' => ($vehicle->getFirstRentDate()) ? $vehicle->getFirstRentDate()->__toString('H:i') : null,
                'rentingEndDate' => ($vehicle->getRentingEndDate()) ? $vehicle->getRentingEndDate()->__toString('d/m/Y') : null,
                'rentingEndTime' => ($vehicle->getRentingEndDate()) ? $vehicle->getRentingEndDate()->__toString('H:i') : null,
                'byeByeDate' => ($vehicle->getByeByeDate()) ? $vehicle->getByeByeDate()->__toString('d/m/Y') : null,
                'initBlockDate' => ($vehicle->getInitBlockageDate()) ? $vehicle->getInitBlockageDate()->__toString('d/m/Y') : null,
                'initBlockTime' => ($vehicle->getInitBlockageDate()) ? $vehicle->getInitBlockageDate()->__toString('H:i') : null,
                'endBlockDate' => ($vehicle->getEndBlockageDate()) ? $vehicle->getEndBlockageDate()->__toString('d/m/Y') : null,
                'endBlockTime' => ($vehicle->getEndBlockageDate()) ? $vehicle->getEndBlockageDate()->__toString('H:i') : null,
                'movementNumber' => $vehicle->getMovementId(),
                'orderNumber' => $vehicle->getOrderNumber(),
                'transportInvoiceNumber' => $vehicle->getTransportInvoiceNumber(),
                'actualUnloadDate' => ($vehicle->getCheckInDate()) ? $vehicle->getCheckInDate()->__toString('d/m/Y') : null,
                'actualUnloadTime' => ($vehicle->getCheckInDate()) ? $vehicle->getCheckInDate()->__toString('H:i') : null,
                'actualLoadingDate' => ($vehicle->getCheckOutDate()) ? $vehicle->getCheckOutDate()->__toString('d/m/Y') : null,
                'actualLoadingTime' => ($vehicle->getCheckOutDate()) ? $vehicle->getCheckOutDate()->__toString('H:i') : null,
                'resaleCode' => ($vehicle->getSaleMethod()) ? $vehicle->getSaleMethod()->getName() : null,
                'salesCustomer' => $vehicle->getSalesCustomerId(),
                'rentalAgreementPickUpDate' => ($vehicle->getRentalAgreementPickUpDate()) ? $vehicle->getRentalAgreementPickUpDate()->__toString('d/m/Y') : null,
                'rentalAgreementPickUpTime' => ($vehicle->getRentalAgreementPickUpDate()) ? $vehicle->getRentalAgreementPickUpDate()->__toString('H:i') : null,
                'rentalAgreementDropOffDate' => ($vehicle->getRentalAgreementDropOffDate()) ? $vehicle->getRentalAgreementDropOffDate()->__toString('d/m/Y') : null,
                'rentalAgreementDropOffTime' => ($vehicle->getRentalAgreementDropOffDate()) ? $vehicle->getRentalAgreementDropOffDate()->__toString('H:i') : null,
            ];
        }


        if ($excel) {
            $body = $this->createVehicleExcelArrayFormatter($vehicleList, $query->getColumns());
            $vehicleList = $body;
            $totalRows = count($body);
        }

        return new FilterVehicleResponse($vehicleList, $totalRows);
    }

    /**
     * @param FilterVehicleQuery $query
     * @return VehicleCriteria
     */
    private function setCriteria(FilterVehicleQuery $query): VehicleCriteria
    {
        $filterCollection = new FilterCollection([]);

        if ($query->getRegionId()) $filterCollection->add(new Filter('REGIONID', new FilterOperator(FilterOperator::EQUAL), $query->getRegionId()));

        if ($query->getAreaId()) $filterCollection->add(new Filter('AREAIDIN', new FilterOperator(FilterOperator::IN), $query->getAreaId()));

        if ($query->getBranchId()) $filterCollection->add(new Filter('BRANCHIDIN', new FilterOperator(FilterOperator::IN), $query->getBranchId()));

        if ($query->getLocationId()) $filterCollection->add(new Filter('LOCATIONIDIN', new FilterOperator(FilterOperator::IN), $query->getLocationId()));

        if ($query->getBrandId()) $filterCollection->add(new Filter('BRANDID', new FilterOperator(FilterOperator::EQUAL), $query->getBrandId()));

        if ($query->getModelId()) $filterCollection->add(new Filter('MODELID', new FilterOperator(FilterOperator::EQUAL), $query->getModelId()));

        if ($query->getTrimId()) $filterCollection->add(new Filter('TRIMID', new FilterOperator(FilterOperator::EQUAL), $query->getTrimId()));

        if ($query->getProviderId()) $filterCollection->add(new Filter('PROVIDERIDIN', new FilterOperator(FilterOperator::IN), $query->getProviderId()));

        // TODO: DE MOMENTO FILTRO FRONT ES SELECTOR, NO MULTIPLE
        if ($query->getPurchaseMethodId()) $filterCollection->add(new Filter('PURCHASEMETHODID', new FilterOperator(FilterOperator::EQUAL), $query->getPurchaseMethodId()[0]));

        if ($query->getSaleMethodId()) $filterCollection->add(new Filter('SALEMETHODID', new FilterOperator(FilterOperator::EQUAL), $query->getSaleMethodId()[0]));

        if ($query->getCarClassIdIn()) $filterCollection->add(new Filter('CARCLASSARRAY', new FilterOperator(FilterOperator::IN), $query->getCarClassIdIn()));

        if ($query->getGroupIdIn()) $filterCollection->add(new Filter('CARGROUPARRAY', new FilterOperator(FilterOperator::IN), $query->getGroupIdIn()));

        if ($query->getAcrissIdIn()) $filterCollection->add(new Filter('ACRISSARRAY', new FilterOperator(FilterOperator::IN), $query->getAcrissIdIn()));

        if ($query->getMotorizationTypeIdIn()) $filterCollection->add(new Filter('MOTORIZATIONTYPEARRAY', new FilterOperator(FilterOperator::IN), $query->getMotorizationTypeIdIn()));

        if ($query->getGearBoxIdIn()) $filterCollection->add(new Filter('GEARBOXARRAY', new FilterOperator(FilterOperator::IN), $query->getGearBoxIdIn()));

        if ($query->getStatusIdIn()) $filterCollection->add(new Filter('VEHICLESTATUSARRAY', new FilterOperator(FilterOperator::IN), $query->getStatusIdIn()));

        if ($query->getActualKmsFrom()) $filterCollection->add(new Filter('KMFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), $query->getActualKmsFrom()));
        if ($query->getActualKmsTo()) $filterCollection->add(new Filter('KMTO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), $query->getActualKmsTo()));

        if ($query->getDeliveryDateFrom()) $filterCollection->add(new Filter('INTDELIVERYDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getDeliveryDateFrom())));
        if ($query->getDeliveryDateTo()) $filterCollection->add(new Filter('INTDELIVERYDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getDeliveryDateTo())));

        if ($query->getFirstRentDateFrom()) $filterCollection->add(new Filter('FIRSTRENTDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getFirstRentDateFrom())));
        if ($query->getFirstRentDateTo()) $filterCollection->add(new Filter('FIRSTRENTDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getFirstRentDateTo())));

        if ($query->getRentingEndDateFrom()) $filterCollection->add(new Filter('RENTINGENDDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getRentingEndDateFrom())));
        if ($query->getRentingEndDateTo()) $filterCollection->add(new Filter('RENTINGENDDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getRentingEndDateTo())));

        if ($query->getByeByeDateFrom()) $filterCollection->add(new Filter('BYEBYEDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getByeByeDateFrom())));
        if ($query->getByeByeDateTo()) $filterCollection->add(new Filter('BYEBYEDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getByeByeDateTo())));

        // TODO colocar nombre a este filtro
        // if ($query->getReturnTransportIdIn()) $filterCollection->add(new Filter('', new FilterOperator(FilterOperator::EQUAL), $query->getReturnTransportIdIn()));

        // TODO colocar nombre a este filtro
        // if ($query->getTransportationAssumedCostBy()) $filterCollection->add(new Filter('', new FilterOperator(FilterOperator::EQUAL), $query->getTransportationAssumedCostBy()));

        if ($query->getReturnDateFrom()) $filterCollection->add(new Filter('RETURNDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getReturnDateFrom())));
        if ($query->getReturnDateTo()) $filterCollection->add(new Filter('RETURNDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getReturnDateTo())));

        if ($query->getCreationDateFrom()) $filterCollection->add(new Filter('CREATIONDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCreationDateFrom())));
        if ($query->getCreationDateTo()) $filterCollection->add(new Filter('CREATIONDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCreationDateTo())));

        if ($query->getRegistrationDateFrom()) $filterCollection->add(new Filter('FIRSTREGISTRATIONDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getRegistrationDateFrom())));
        if ($query->getRegistrationDateTo()) $filterCollection->add(new Filter('FIRSTREGISTRATIONDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getRegistrationDateTo())));

        if ($query->getInitBlockageDateFrom()) $filterCollection->add(new Filter('DATEBLOCKAGEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getInitBlockageDateFrom())));
        if ($query->getInitBlockageDateTo()) $filterCollection->add(new Filter('DATEBLOCAKGETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getInitBlockageDateTo())));

        if ($query->getEndBlockageDateFrom()) $filterCollection->add(new Filter('DATEBLOCKAGEENDFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getEndBlockageDateFrom())));
        if ($query->getEndBlockageDateTo()) $filterCollection->add(new Filter('DATEBLOCKAGEENDTO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getEndBlockageDateTo())));

        if ($query->getCheckInDateFrom()) $filterCollection->add(new Filter('UNLOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCheckInDateFrom())));
        if ($query->getCheckInDateTo()) $filterCollection->add(new Filter('UNLOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCheckInDateTo())));

        if ($query->getCheckOutDateFrom()) $filterCollection->add(new Filter('LOADDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCheckOutDateFrom())));
        if ($query->getCheckOutDateTo()) $filterCollection->add(new Filter('LOADDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN), Utils::formatStringDateTimeToOdataDate($query->getCheckOutDateTo())));

        if ($query->getVehicleTypeIdIn()) $filterCollection->add(new Filter('VEHICLETYPEARRAY', new FilterOperator(FilterOperator::IN), $query->getVehicleTypeIdIn()));

        if ($query->getConnectedIn()) $filterCollection->add(new Filter('CONNECTEDVEHICLEIN', new FilterOperator(FilterOperator::EQUAL), $query->getConnectedIn()));

        if ($query->getSaleMethodId()) $filterCollection->add(new Filter('RESALECODEARRAY', new FilterOperator(FilterOperator::IN), $query->getSaleMethodId()));
        
        if ($query->getCleanVehicle() !== null && $query->getCleanVehicle() !== '') {
            $cleanVehicle = intval($query->getCleanVehicle());
            if ($cleanVehicle === 1) {
                $filterCollection->add(new Filter('EXTERIORCLEAN', new FilterOperator(FilterOperator::EQUAL), 1));
                $filterCollection->add(new Filter('INTERIORCLEAN', new FilterOperator(FilterOperator::EQUAL), 1));
            } elseif ($cleanVehicle === 0) {
                 $filterCollection->add(new Filter('EXTERIORCLEAN_OR_INTERIORCLEAN', new FilterOperator(FilterOperator::EQUAL), 0));
            }
            
        }
        $sortCollection = null;
        if (!empty($query->getSort()) && !empty($query->getOrder())) {
            $sortCollection = new SortCollection([
                new Sort($query->getSort(), $query->getOrder())
            ]);
        }
        $pagination = new Pagination($query->getLimit(), $query->getOffset(), $sortCollection);

        return new VehicleCriteria($filterCollection, $pagination);
    }

    private function createVehicleExcelArrayFormatter(array $vehicles, array $columns): array
    {
        //Devolver de vehículo los indices que esten en columns
        $vehiclesExcel = [];
        /** 
         * @var Vehicle $vehicle
         */
        foreach ($vehicles as $vehicle) {
            $vehicleItem = [];
            foreach ($columns as $column) {
                $vehicleItem[] = $vehicle[$column];
            }
            $vehiclesExcel[] = $vehicleItem;
        }
        return $vehiclesExcel;
    }
}
