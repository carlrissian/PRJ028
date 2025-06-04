<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\StoreMovement;

use DateTime;
use Exception;
use Distribution\Movement\Domain\State;
use Distribution\Movement\Domain\Branch;
use Distribution\Movement\Domain\Driver;
use Distribution\Movement\Domain\Location;
use Distribution\Movement\Domain\Movement;
use Distribution\Movement\Domain\Supplier;
use Distribution\Movement\Domain\Department;
use Distribution\Movement\Domain\VehicleLine;
use Distribution\Movement\Domain\BusinessUnit;
use Distribution\Movement\Domain\MovementType;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\Movement\Domain\VehicleFilter;
use Shared\Domain\ValueObject\FloatValueObject;
use Distribution\Movement\Domain\ManualLocation;
use Distribution\Movement\Domain\MovementStatus;
use Distribution\Movement\Domain\VehicleRecords;
use Distribution\Movement\Domain\TransportMethod;
use Distribution\Movement\Domain\Vehicle\Country;
use Distribution\Movement\Domain\Vehicle\Vehicle;
use Distribution\Movement\Domain\MovementCategory;
use Distribution\Vehicle\Domain\VehicleRepository;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Location\Domain\LocationRepository;
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
use Distribution\Movement\Domain\Vehicle\VehicleStatus as VehicleLineVehicleStatus;

class StoreMovementCommandHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;

    /**
     * @var VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * StoreMovementCommandHandler constructor.
     *
     * @param MovementRepository $movementRepository
     * @param LocationRepository $locationRepository
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(
        MovementRepository $movementRepository,
        LocationRepository $locationRepository,
        VehicleRepository $vehicleRepository
    ) {
        $this->movementRepository = $movementRepository;
        $this->locationRepository = $locationRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @param StoreMovementCommand $command
     * @return StoreMovementResponse
     *
     * @throws Exception
     */
    final public function handle(StoreMovementCommand $command): StoreMovementResponse
    {
        [
            $movementTypeId,
            $movementCategory,
            $movementStatus,
            $vehicleFilterCollection,
            $vehicleLineCollection,
            $driver,
            $originLocation,
            $originExternalLocation,
            $originExternalSupplierCode,
            $originManuallLocation,
            $originBranch,
            $destinationLocation,
            $destinationExternalLocation,
            $destinationExternalSupplierCode,
            $destinationManuallLocation,
            $destinationBranch,
            $transportMethod
        ] = null;

        $movementTypeId = $command->getMovementTypeId();
        $extTransport = $command->getExtTransport();


        // Origin location/branch
        if ($command->getOriginLocationId()) {
            $originLocation = new Location($command->getOriginLocationId());

            $location = $this->locationRepository->getById($command->getOriginLocationId());
            $originBranch = ($location) ? new Branch($location->getBranch()->getId()) : null;
        }
        // Destination location/branch
        if ($command->getDestinationLocationId()) {
            $destinationLocation = new Location($command->getDestinationLocationId());

            $location = $this->locationRepository->getById($command->getDestinationLocationId());
            $destinationBranch = ($location) ? new Branch($location->getBranch()->getId()) : null;
        }


        /**
         * DRIVER
         */
        if ($movementTypeId === intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER"))) {
            // Por defecto movimiento por conductor estado IN_PROGRESS
            $movementStatus = new MovementStatus(intval(ConstantsJsonFile::getValue("TRANSPORTSTATUS_IN_PROGRESS")));
            $movementCategory = new MovementCategory($command->getMovementCategoryId());

            if (empty($command->getDriverId())) {
                throw new Exception("You cannot create a driver movement without first select or create a driver");
            }
            $driver = new Driver($command->getDriverId());

            $vehicle = $this->vehicleRepository->getById($command->getVehicleId());
            $vehicleLineCollection =
                new VehicleLineCollection([
                    new VehicleLine(
                        new Vehicle(
                            $vehicle->getId(),
                            null,
                            null,
                            $vehicle->getStatus() ?
                                new VehicleLineVehicleStatus(
                                    $vehicle->getStatus()->getId(),
                                    $vehicle->getStatus()->getName()
                                ) : null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            $vehicle->getTankCapacity(),
                            $vehicle->getBatteryCapacity()
                        ),
                        // DateTimeValueObject::createFromString($command->getExpectedLoadDate()),
                        new DateTimeValueObject(new DateTime()),
                        null,
                        new VehicleRecords(
                            $vehicle->getActualKms(),
                            $vehicle->getBatteryActual() ? FloatValueObject::create($vehicle->getBatteryActual()) : null,
                            $vehicle->getTankActualOctaves()
                        )
                    )
                ]);


            /**
             * Manual locations
             */
            // Manual origin location
            if ($command->getManualOriginLocationCountryId() && $command->getManualOriginLocationProvinceId()) {
                $originManuallLocation = new ManualLocation(
                    new Country($command->getManualOriginLocationCountryId()),
                    new State($command->getManualOriginLocationProvinceId()),
                    $command->getManualOriginLocationNotes()
                );

                $originLocation = null;
            }
            // Manual destination location
            if ($command->getManualDestinationLocationCountryId() && $command->getManualDestinationLocationProvinceId()) {
                $destinationManuallLocation = new ManualLocation(
                    new Country($command->getManualDestinationLocationCountryId()),
                    new State($command->getManualDestinationLocationProvinceId()),
                    $command->getManualDestinationLocationNotes()
                );

                $destinationLocation = null;
            }
        } else {
            // Por defecto resto tipo de movimientos estado pending
            $movementStatus = new MovementStatus(intval(ConstantsJsonFile::getValue("TRANSPORTSTATUS_PENDING")));
        }

        /**
         * CARRIER
         */
        if ($movementTypeId === intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER"))) {
            $transportMethod = new TransportMethod($command->getTransportMethodId());

            /**
             * Origin external location
             */
            if ($command->getOriginExternalProviderId() && $command->getOriginExternalLocationId()) {
                $originExternalSupplierCode = new Supplier($command->getOriginExternalProviderId());
                $originExternalLocation = new Location($command->getOriginExternalLocationId());

                $originLocation = null;
                $originManuallLocation = null;
            }
        }

        /**
         * OPERATION
         */
        if ($movementTypeId === intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_OPERATION"))) {
            $extTransport = false;
        }

        /**
         * Filters en CARRIER y OPERATION
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
        }


        /**
         * Destination external location en DRIVER y CARRIER
         */
        if (in_array($movementTypeId, [ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER"), ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER")])) {
            if ($command->getDestinationExternalProviderId() && $command->getDestinationExternalLocationId()) {
                $destinationExternalSupplierCode = new Supplier($command->getDestinationExternalProviderId());
                $destinationExternalLocation = new Location($command->getDestinationExternalLocationId());

                $destinationLocation = null;
                $destinationManuallLocation = null;
            }
        }


        $movement = new Movement(
            null,
            null,
            new MovementType($movementTypeId),
            $movementCategory,
            $extTransport,
            $movementStatus,
            $originLocation,
            $originManuallLocation,
            $originExternalLocation,
            $originExternalSupplierCode,
            $originBranch,
            $destinationLocation,
            $destinationManuallLocation,
            $destinationExternalLocation,
            $destinationExternalSupplierCode,
            $destinationBranch,
            ($command->getExpectedLoadDate()) ? DateValueObject::createFromString($command->getExpectedLoadDate()) : null,
            ($command->getActualLoadDate()) ? DateTimeValueObject::createFromString($command->getActualLoadDate()) : null,
            ($command->getExpectedUnloadDate()) ? DateValueObject::createFromString($command->getExpectedUnloadDate()) : null,
            ($command->getActualUnloadDate()) ? DateTimeValueObject::createFromString($command->getActualUnloadDate()) : null,
            ($command->getDepartmentId()) ? new Department($command->getDepartmentId()) : null,
            ($command->getProviderId()) ? new Supplier($command->getProviderId()) : null,
            $driver,
            ($command->getBusinessUnitId()) ? new BusinessUnit($command->getBusinessUnitId()) : null,
            ($command->getBusinessUnitArticleId()) ? new BusinessUnitArticle($command->getBusinessUnitArticleId()) : null,
            (is_numeric($command->getAutomaticCost())) ? FloatValueObject::create($command->getAutomaticCost()) : null,
            (is_numeric($command->getManualCost())) ? FloatValueObject::create($command->getManualCost()) : null,
            $command->getVehicleUnits(),
            $command->getNotes(),
            $vehicleLineCollection,
            $vehicleFilterCollection,
            null,
            null,
            $transportMethod
        );

        $response = $this->movementRepository->store($movement);

        return new StoreMovementResponse(
            $response->getId(),
            $response->getOperationResponse()->wasSuccess(),
            $response->getOperationResponse()->getCode(),
            $response->getOperationResponse()->getMessage()
        );
    }
}
