<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\UpdateMovement;

use Exception;
use Distribution\Movement\Domain\State;
use Distribution\Movement\Domain\Driver;
use Distribution\Movement\Domain\Location;
use Distribution\Movement\Domain\Movement;
use Distribution\Movement\Domain\Supplier;
use Distribution\Movement\Domain\Department;
use Distribution\Movement\Domain\BusinessUnit;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\Movement\Domain\VehicleFilter;
use Shared\Domain\ValueObject\FloatValueObject;
use Distribution\Movement\Domain\ManualLocation;
use Distribution\Movement\Domain\TransportMethod;
use Distribution\Movement\Domain\Vehicle\Country;
use Distribution\Movement\Domain\MovementCategory;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\Movement\Domain\BusinessUnitArticle;
use Distribution\Movement\Domain\VehicleFilter\Brand;
use Distribution\Movement\Domain\VehicleFilter\Model;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Distribution\Movement\Domain\VehicleLineCollection;
use Distribution\Movement\Domain\VehicleFilter\CarGroup;
use Distribution\Movement\Domain\VehicleFilterCollection;
use Distribution\Movement\Domain\VehicleFilter\SaleMethod;
use Distribution\Movement\Domain\VehicleFilter\VehicleType;
use Distribution\Movement\Domain\VehicleFilter\VehicleStatus;
use Distribution\Movement\Domain\VehicleFilter\BrandCollection;
use Distribution\Movement\Domain\VehicleFilter\ModelCollection;
use Distribution\Movement\Domain\VehicleFilter\CarGroupCollection;
use Distribution\Movement\Domain\VehicleFilter\SaleMethodCollection;
use Distribution\Movement\Domain\VehicleFilter\VehicleTypeCollection;
use Distribution\Movement\Domain\VehicleFilter\VehicleStatusCollection;

class UpdateMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * UpdateMovementCommandHandler constructor.
     *
     * @param MovementRepository $movementRepository
     */
    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    /**
     * @param UpdateMovementCommand $command
     * @return UpdateMovementResponse
     * 
     * @throws Exception
     */
    final public function handle(UpdateMovementCommand $command): UpdateMovementResponse
    {
        $movementTypeId = $command->getMovementTypeId();

        /**
         * @var Movement $movement
         */
        $movement = $this->movementRepository->getById($command->getId());

        if (empty($movement)) {
            throw new Exception('Movement not found');
        }


        // Origin location
        if ($command->getOriginLocationId()) {
            $movement->setOriginLocation(new Location($command->getOriginLocationId()));

            if ($movement->getManualOriginLocation()) $movement->setManualOriginLocation(null);
            if ($movement->getOriginExternalLocation()) $movement->setOriginExternalLocation(null);
            if ($movement->getOriginExternalSupplier()) $movement->setOriginExternalSupplier(null);
        }
        // Destination location
        if ($command->getDestinationLocationId()) {
            $movement->setDestinationLocation(new Location($command->getDestinationLocationId()));

            if ($movement->getManualDestinationLocation()) $movement->setManualDestinationLocation(null);
            if ($movement->getDestinationExternalLocation()) $movement->setDestinationExternalLocation(null);
            if ($movement->getDestinationExternalSupplier()) $movement->setDestinationExternalSupplier(null);
        }


        /**
         * DRIVER
         */
        if ($movementTypeId === intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER"))) {
            $movement->setMovementCategory(new MovementCategory($command->getMovementCategoryId()));
            $movement->setExtTransport($command->getExtTransport());
            $movement->setDepartment(new Department($command->getDepartmentId()));

            // Driver
            if ($command->getDriverId() && ($movement->getDriver()->getId() !== $command->getDriverId())) {
                $movement->setDriver(new Driver($command->getDriverId()));
            }

            // Manual origin location
            if ($command->getManualOriginLocationCountryId() && $command->getManualOriginLocationProvinceId()) {
                $movement->setManualOriginLocation(new ManualLocation(
                    new Country($command->getManualOriginLocationCountryId()),
                    new State($command->getManualOriginLocationProvinceId()),
                    $command->getManualOriginLocationNotes()
                ));

                if ($movement->getOriginLocation()) $movement->setOriginLocation(null);
                if ($movement->getOriginExternalLocation()) $movement->setOriginExternalLocation(null);
                if ($movement->getOriginExternalSupplier()) $movement->setOriginExternalSupplier(null);
            }

            // Manual destination location
            if ($command->getManualDestinationLocationCountryId() && $command->getManualDestinationLocationProvinceId()) {
                $movement->setManualDestinationLocation(new ManualLocation(
                    new Country($command->getManualDestinationLocationCountryId()),
                    new State($command->getManualDestinationLocationProvinceId()),
                    $command->getManualDestinationLocationNotes()
                ));

                if ($movement->getDestinationLocation()) $movement->setDestinationLocation(null);
                if ($movement->getDestinationExternalLocation()) $movement->setDestinationExternalLocation(null);
                if ($movement->getDestinationExternalSupplier()) $movement->setDestinationExternalSupplier(null);
            }
        }


        /**
         * CARRIER
         */
        if ($movementTypeId === intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER"))) {
            // Es transporte externo
            $movement->setExtTransport(true);

            if ($command->getTransportMethodId() && $movement->getTransportMethod() && ($movement->getTransportMethod()->getId() !== $command->getTransportMethodId())) {
                $movement->setTransportMethod(new TransportMethod($command->getTransportMethodId()));
            }

            $movement->setAutomaticCost(is_numeric($command->getAutomaticCost()) ? FloatValueObject::create($command->getAutomaticCost()) : null);

            /**
             * Origin external location
             */
            if ($command->getOriginExternalLocationId()) {
                $movement->setOriginExternalLocation(new Location($command->getOriginExternalLocationId()));
                $movement->setOriginExternalSupplier(new Supplier($command->getOriginExternalProviderId()));

                if ($movement->getOriginLocation()) $movement->setOriginLocation(null);
                if ($movement->getManualOriginLocation()) $movement->setManualOriginLocation(null);
            }
        }


        /**
         * CARRIER, OPERATION
         */
        if (in_array($movementTypeId, [ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER"), ConstantsJsonFile::getValue("TRANSPORTTYPE_OPERATION")])) {
            /**
             * Filters
             */
            $vehicleFilterCollection = new VehicleFilterCollection([]);
            $vehicleType = $command->getVehicleType();
            $brand = $command->getBrand();
            $model = $command->getModel();
            $carGroup = $command->getCarGroup();
            $saleMethod = $command->getSaleMethod();
            $vehicleStatus = $command->getVehicleStatus();

            // VehicleType
            $vehicleTypeCollection = new VehicleTypeCollection([]);
            if ($vehicleType !== null) {
                foreach ($vehicleType as $vehicleTypeId) {
                    $vehicleTypeCollection->add(new VehicleType(intval($vehicleTypeId)));
                }
            }

            // Brand
            $brandCollection = new BrandCollection([]);
            if ($brand !== null) {
                foreach ($brand as $brandId) {
                    $brandCollection->add(new Brand(intval($brandId)));
                }
            }

            // Model
            $modelCollection = new ModelCollection([]);
            if ($model !== null) {
                foreach ($model as $modelId) {
                    $modelCollection->add(new Model(intval($modelId)));
                }
            }

            // CarGroup
            $carGroupCollection = new CarGroupCollection([]);
            if ($carGroup !== null) {
                foreach ($carGroup as $carGroupId) {
                    $carGroupCollection->add(new CarGroup(intval($carGroupId)));
                }
            }

            // SaleMethod
            $saleMethodCollection = new SaleMethodCollection([]);
            if ($saleMethod !== null) {
                foreach ($saleMethod as $saleMethodId) {
                    $saleMethodCollection->add(new SaleMethod(intval($saleMethodId)));
                }
            }

            // VehicleStatus
            $vehicleStatusCollection = new VehicleStatusCollection([]);
            if ($vehicleStatus !== null) {
                foreach ($vehicleStatus as $vehicleStatusId) {
                    $vehicleStatusCollection->add(new VehicleStatus(intval($vehicleStatusId)));
                }
            }

            $vehicleFilterCollection->add(new VehicleFilter(
                $vehicleTypeCollection,
                $brandCollection,
                $modelCollection,
                $carGroupCollection,
                $command->getKilometersFrom(),
                $command->getKilometersTo(),
                $command->getRentingEndDateFrom() ? DateValueObject::createFromString($command->getRentingEndDateFrom()) : null,
                $command->getRentingEndDateTo() ? DateValueObject::createFromString($command->getRentingEndDateTo()) : null,
                $saleMethodCollection,
                $command->getCheckInDateFrom() ? DateValueObject::createFromString($command->getCheckInDateFrom()) : null,
                $vehicleStatusCollection,
                $command->getConnectedVehicle()
            ));
            $movement->setVehicleFilterCollection($vehicleFilterCollection);

            // Si se modifica la localización de origen, se eliminan los vehículos
            // if ($command->getOriginLocationId() && ($movement->getOriginLocation()->getId() !== $command->getOriginLocationId())) {
            //     $movement->setVehicleLineCollection(new VehicleLineCollection([]));
            // }
            /**
             * Actualización de la lógica de arriba: eliminamos los vehículos directamente porque interrumpe los cambios de datos referentes a cabecera.
             * Si se envían líneas en la request, WS las recibe e interpreta como que se quieren añadir/modificar líneas.
             */
            $movement->setVehicleLineCollection(new VehicleLineCollection([]));
        }

        /**
         * Destination external location en DRIVER y CARRIER
         */
        if (in_array($movementTypeId, [ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER"), ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER")])) {
            if ($command->getDestinationExternalLocationId()) {
                $movement->setDestinationExternalLocation(new Location($command->getDestinationExternalLocationId()));
                $movement->setDestinationExternalSupplier(new Supplier($command->getDestinationExternalProviderId()));

                if ($movement->getDestinationLocation()) $movement->setDestinationLocation(null);
                if ($movement->getManualDestinationLocation()) $movement->setManualDestinationLocation(null);
            }
        }


        $movement->setSupplier(($command->getProviderId()) ? new Supplier($command->getProviderId()) : $command->getProviderId());
        $movement->setBusinessUnit(new BusinessUnit($command->getBusinessUnitId()));
        $movement->setBusinessUnitArticle(new BusinessUnitArticle($command->getBusinessUnitArticleId()));

        $movement->setManualCost(is_numeric($command->getManualCost()) ? FloatValueObject::create($command->getManualCost()) : null);
        $movement->setNotes($command->getNotes());

        /**
         * 2023/09/20: TODO Comprobar que fechas son obligadas
         * 2024/08/02: Los expected son obligatorios, los actual no tienen modificación vía front
         */
        if ($command->getExpectedLoadDate()) {
            $movement->setExpectedLoadDate(DateValueObject::createFromString($command->getExpectedLoadDate()));
        }
        // if ($command->getActualLoadDate()) {
        //     $movement->setActualLoadDate(DateTimeValueObject::createFromString($command->getActualLoadDate()));
        // }
        if ($command->getExpectedUnloadDate()) {
            $movement->setExpectedUnloadDate(DateValueObject::createFromString($command->getExpectedUnloadDate()));
        }
        // if ($command->getActualUnloadDate()) {
        //     $movement->setActualUnloadDate(DateTimeValueObject::createFromString($command->getActualUnloadDate()));
        // }

        $movement->setVehicleUnits($command->getVehicleUnits());

        // Movimientos por conductor no aplica a la lógica establecida en WS acerca de eliminación de líneas
        $movement->setOnlyEditHead($movementTypeId !== intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER")));

        $response = $this->movementRepository->update($movement);

        return new UpdateMovementResponse(
            $response->getId(),
            $response->getOperationResponse()->wasSuccess(),
            $response->getOperationResponse()->getCode(),
            $response->getOperationResponse()->getMessage()
        );
    }
}
