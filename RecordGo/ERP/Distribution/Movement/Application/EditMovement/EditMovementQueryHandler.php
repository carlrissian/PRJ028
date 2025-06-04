<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\EditMovement;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use App\Constants\MovementConstants;
use Distribution\Location\Domain\Location;
use Distribution\Movement\Domain\Movement;
use Distribution\Movement\Domain\Supplier;
use Shared\Domain\Criteria\FilterOperator;
use App\Constants\ConnectedVehicleConstants;
use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Model\Domain\ModelCriteria;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Brand\Domain\BrandException;
use Distribution\Model\Domain\ModelException;
use Distribution\Movement\Domain\VehicleLine;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Brand\Domain\BrandRepository;
use Distribution\Model\Domain\ModelRepository;
use Distribution\Branch\Domain\BranchException;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Country\Domain\CountryCriteria;
use Distribution\Country\Domain\CountryException;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\Country\Domain\CountryRepository;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\Supplier\Domain\SupplierCriteria;
use Distribution\CarGroup\Domain\CarGroupException;
use Distribution\Location\Domain\LocationException;
use Distribution\Movement\Domain\MovementException;
use Distribution\Supplier\Domain\SupplierException;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\Location\Domain\LocationRepository;
use Distribution\Movement\Domain\MovementRepository;
use Distribution\Supplier\Domain\SupplierRepository;
use Distribution\Department\Domain\DepartmentCriteria;
use Distribution\SaleMethod\Domain\SaleMethodCriteria;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Distribution\Department\Domain\DepartmentException;
use Distribution\Department\Domain\DepartmentRepository;
use Distribution\SaleMethod\Domain\SaleMethodRepository;
use Distribution\VehicleType\Domain\VehicleTypeCriteria;
use Distribution\BusinessUnit\Domain\BusinessUnitCriteria;
use Distribution\VehicleType\Domain\VehicleTypeRepository;
use Distribution\BusinessUnit\Domain\BusinessUnitException;
use Distribution\BusinessUnit\Domain\BusinessUnitRepository;
use Distribution\VehicleStatus\Domain\VehicleStatusCriteria;
use Distribution\Movement\Domain\Location as MovementLocation;
use Distribution\MovementStatus\Domain\MovementStatusCriteria;
use Distribution\VehicleStatus\Domain\VehicleStatusRepository;
use Distribution\MovementStatus\Domain\MovementStatusException;
use Distribution\SaleMethod\Domain\SaleMethodNotFoundException;
use Distribution\MovementStatus\Domain\MovementStatusRepository;
use Distribution\TransportMethod\Domain\TransportMethodCriteria;
use Distribution\TransportMethod\Domain\TransportMethodException;
use Distribution\VehicleType\Domain\VehicleTypeNotFoundException;
use Distribution\MovementCategory\Domain\MovementCategoryCriteria;
use Distribution\TransportMethod\Domain\TransportMethodRepository;
use Distribution\MovementCategory\Domain\MovementCategoryException;
use Distribution\MovementCategory\Domain\MovementCategoryRepository;
use Distribution\VehicleStatus\Domain\VehicleStatusNotFoundException;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleCriteria;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleException;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleRepository;

class EditMovementQueryHandler
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * @var MovementCategoryRepository
     */
    private MovementCategoryRepository $movementCategoryRepository;

    /**
     * @var MovementStatusRepository
     */
    private MovementStatusRepository $movementStatusRepository;

    /**
     * @var TransportMethodRepository
     */
    private TransportMethodRepository $transportMethodRepository;

    /**
     * @var SupplierRepository
     */
    private SupplierRepository $supplierRepository;

    /**
     * @var DepartmentRepository
     */
    private DepartmentRepository $departmentRepository;

    /**
     * @var BusinessUnitRepository
     */
    private BusinessUnitRepository $businessUnitRepository;

    /**
     * @var BusinessUnitArticleRepository
     */
    private BusinessUnitArticleRepository $businessUnitArticleRepository;

    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;


    /**
     * @var BranchRepository
     */
    private BranchRepository $branchRepository;

    /**
     * @var CountryRepository
     */
    private CountryRepository $countryRepository;

    /**
     * @var VehicleTypeRepository
     */
    private VehicleTypeRepository $vehicleTypeRepository;

    /**
     * @var VehicleStatusRepository
     */
    private VehicleStatusRepository $vehicleStatusRepository;

    /**
     * @var BrandRepository
     */
    private BrandRepository $brandRepository;

    /**
     * @var ModelRepository
     */
    private ModelRepository $modelRepository;

    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $carGroupRepository;

    /**
     * @var SaleMethodRepository
     */
    private SaleMethodRepository $saleMethodRepository;

    /**
     * EditMovementQueryHandler constructor.
     * 
     * @param MovementRepository $movementRepository
     * @param MovementCategoryRepository $movementCategoryRepository
     * @param MovementStatusRepository $movementStatusRepository
     * @param TransportMethodRepository $transportMethodRepository
     * @param SupplierRepository $supplierRepository
     * @param DepartmentRepository $departmentRepository
     * @param BusinessUnitRepository $businessUnitRepository
     * @param BusinessUnitArticleRepository $businessUnitArticleRepository
     * @param BranchRepository $branchRepository
     * @param CountryRepository $countryRepository
     * @param VehicleTypeRepository $vehicleTypeRepository
     * @param VehicleStatusRepository $vehicleStatusRepository
     * @param BrandRepository $brandRepository
     * @param ModelRepository $modelRepository
     * @param CarGroupRepository $carGroupRepository
     * @param SaleMethodRepository $saleMethodRepository
     */
    public function __construct(
        MovementRepository $movementRepository,
        MovementCategoryRepository $movementCategoryRepository,
        MovementStatusRepository $movementStatusRepository,
        TransportMethodRepository $transportMethodRepository,
        SupplierRepository $supplierRepository,
        DepartmentRepository $departmentRepository,
        BusinessUnitRepository $businessUnitRepository,
        BusinessUnitArticleRepository $businessUnitArticleRepository,
        LocationRepository $locationRepository,
        BranchRepository $branchRepository,
        CountryRepository $countryRepository,
        VehicleTypeRepository $vehicleTypeRepository,
        VehicleStatusRepository $vehicleStatusRepository,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        CarGroupRepository $carGroupRepository,
        SaleMethodRepository $saleMethodRepository
    ) {
        $this->movementRepository = $movementRepository;
        $this->movementCategoryRepository = $movementCategoryRepository;
        $this->movementStatusRepository = $movementStatusRepository;
        $this->transportMethodRepository = $transportMethodRepository;
        $this->supplierRepository = $supplierRepository;
        $this->departmentRepository = $departmentRepository;
        $this->businessUnitRepository = $businessUnitRepository;
        $this->businessUnitArticleRepository = $businessUnitArticleRepository;
        $this->locationRepository = $locationRepository;
        $this->branchRepository = $branchRepository;
        $this->countryRepository = $countryRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->vehicleStatusRepository = $vehicleStatusRepository;
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        $this->carGroupRepository = $carGroupRepository;
        $this->saleMethodRepository = $saleMethodRepository;
    }

    /**
     * @param EditMovementQuery $query
     * @return EditMovementResponse
     * 
     * @throws MovementException
     * @throws MovementCategoryException
     * @throws MovementStatusException
     * @throws TransportMethodException
     * @throws SupplierException
     * @throws DepartmentException
     * @throws BusinessUnitException
     * @throws BusinessUnitArticleException
     * @throws BranchException
     * @throws CountryException
     * @throws VehicleTypeNotFoundException
     * @throws VehicleStatusNotFoundException
     * @throws BrandException
     * @throws ModelException
     * @throws CarGroupException
     * @throws SaleMethodNotFoundException
     */
    public function handle(EditMovementQuery $query): EditMovementResponse
    {
        /**
         * @var Movement $movement
         */
        $movement = $this->movementRepository->getById($query->getId());
        if (empty($movement)) {
            throw new MovementException('Error getting movement');
        }

        $movementCategoryCollection = $this->movementCategoryRepository->getBy(new MovementCategoryCriteria())->getCollection();
        if (empty($movementCategoryCollection)) {
            throw new MovementCategoryException('Error getting movement category');
        }

        $movementStatusCollection = $this->movementStatusRepository->getBy(new MovementStatusCriteria())->getCollection();
        if (empty($movementStatusCollection)) {
            throw new MovementStatusException('Error getting movement status');
        }

        $transportMethodCollection = $this->transportMethodRepository->getBy(new TransportMethodCriteria())->getCollection();
        if (empty($transportMethodCollection)) {
            throw new TransportMethodException('Error getting transport method');
        }

        $supplierCollection = $this->supplierRepository->getBy(new SupplierCriteria())->getCollection();
        if (empty($supplierCollection)) {
            throw new SupplierException('Error getting supplier');
        }

        $departmentCollection = $this->departmentRepository->getBy(new DepartmentCriteria())->getCollection();
        if (empty($departmentCollection)) {
            throw new DepartmentException('Error getting department');
        }

        $businessUnitCollection = $this->businessUnitRepository->getBy(new BusinessUnitCriteria())->getCollection();
        if (empty($businessUnitCollection)) {
            throw new BusinessUnitException('Error getting business unit');
        }

        switch ($movement->getMovementType()->getId()) {
            case ConstantsJsonFile::getValue('TRANSPORTTYPE_CARRIER'):
                $subfamilia = ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_U_EXO_SUBFAMILIA_CARRIER');
                break;
            case ConstantsJsonFile::getValue('TRANSPORTTYPE_OPERATION'):
                $subfamilia = ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_U_EXO_SUBFAMILIA_OPERATION');
                break;
            case ConstantsJsonFile::getValue('TRANSPORTTYPE_DRIVER'):
            default:
                $subfamilia = ConstantsJsonFile::getValue('BUSINESSUNITARTICLE_U_EXO_SUBFAMILIA_DRIVER');
                break;
        }

        $filterCollection = new FilterCollection([
            new Filter('U_EXO_SUBFAMILIA', new FilterOperator(FilterOperator::EQUAL), $subfamilia)
        ]);
        $businessUnitArticleCollection = $this->businessUnitArticleRepository->getBy(new BusinessUnitArticleCriteria($filterCollection))->getCollection();
        if (empty($businessUnitArticleCollection)) {
            throw new BusinessUnitArticleException('Error getting business unit article');
        }

        $filterCollection = new FilterCollection([
            new Filter('HASPARTNER', new FilterOperator(FilterOperator::EQUAL), 0)
        ]);
        $locationCollection = $this->locationRepository->getBy(new LocationCriteria($filterCollection))->getCollection();
        if (empty($locationCollection)) {
            throw new LocationException('Error getting locations');
        }

        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();
        if (empty($branchCollection)) {
            throw new BranchException('Error getting branch');
        }

        $countryCollection = $this->countryRepository->getBy(new CountryCriteria())->getCollection();
        if (empty($countryCollection)) {
            throw new CountryException('Error getting country');
        }

        $vehicleTypeCollection = $this->vehicleTypeRepository->getBy(new VehicleTypeCriteria())->getCollection();
        if (empty($vehicleTypeCollection)) {
            throw new VehicleTypeNotFoundException('Error getting vehicle type');
        }

        $vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection();
        if (empty($vehicleStatusCollection)) {
            throw new VehicleStatusNotFoundException('Error getting vehicle status');
        }

        $brandCollection = $this->brandRepository->getBy(new BrandCriteria())->getCollection();
        if (empty($brandCollection)) {
            throw new BrandException('Error getting brand');
        }

        $modelCollection = $this->modelRepository->getBy(new ModelCriteria())->getCollection();
        if (empty($modelCollection)) {
            throw new ModelException('Error getting model');
        }

        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        if (empty($carGroupCollection)) {
            throw new CarGroupException('Error getting vehicle group');
        }

        $saleMethodCollection = $this->saleMethodRepository->getBy(new SaleMethodCriteria())->getCollection();
        if (empty($saleMethodCollection)) {
            throw new SaleMethodNotFoundException('Error getting sale method');
        }

        /**
         * Listado de selectores
         */

        $movementCategoryList = Utils::createSelect($movementCategoryCollection);
        $movementStatusList = Utils::createSelect($movementStatusCollection);
        $transportMethodList = Utils::createSelect($transportMethodCollection);
        $supplierList = Utils::createSelect($supplierCollection);
        $departmentList = Utils::createSelect($departmentCollection);
        $businessUnitList = Utils::createSelect($businessUnitCollection);
        $businessUnitArticleList = Utils::createSelect($businessUnitArticleCollection);

        $locationList = [];
        foreach ($locationCollection as $location) {
            $locationList[] = [
                'id' => $location->getId(),
                'name' => $location->getName(),
                'branchId' => $location->getBranch() ? $location->getBranch()->getId() : null,
                'branchIATA' => $location->getBranch() ? $location->getBranch()->getBranchIATA() : null,
                'branchGroupId' => $location->getBranch() ? $location->getBranch()->getBranchGroupId() : null
            ];
        }

        $branchList = Utils::createSelect($branchCollection);
        $countryList = Utils::createSelect($countryCollection);
        $vehicleTypeList = Utils::createSelect($vehicleTypeCollection);
        $vehicleStatusList = Utils::createSelect($vehicleStatusCollection);
        $brandList = Utils::createSelect($brandCollection);
        $modelList = Utils::createCustomSelectList($modelCollection, 'id', 'name', 'brand.id');
        $carGroupList = Utils::createSelect($carGroupCollection);
        $saleMethodList = Utils::createSelect($saleMethodCollection);

        $connectedVehicleList = [
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_YES, 'name' => 'Sí'],
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_NO, 'name' => 'No'],
        ];

        /********************************/

        [
            $driver,
            $vehicle,
            $vehicleLineList,
            $vehicleFilter,
        ] = null;

        /**
         * DRIVER
         */
        if ($movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue('TRANSPORTTYPE_DRIVER'))) {
            // FIXME esta lógica es un parche temporal para declarar si una localización es externa o no. Refactorizar cuando se cambie el response de WS
            if ($movement->getDestinationLocation()) {
                /**
                 * @var Location $location
                 */
                $location = $this->locationRepository->getById($movement->getDestinationLocation()->getId());

                if ($location->getProvider()) {
                    $movement->setDestinationExternalSupplier(new Supplier(
                        $location->getProvider()->getId(),
                        $location->getProvider()->getName()
                    ));
                    $movement->setDestinationExternalLocation(new MovementLocation(
                        $movement->getDestinationLocation()->getId(),
                        $movement->getDestinationLocation()->getName()
                    ));
                    $movement->setDestinationLocation(null);
                }
            }


            $driver = $movement->getDriver() ?
                [
                    'id' => $movement->getDriver()->getId(),
                    'name' => $movement->getDriver()->getName(),
                    'lastName' => $movement->getDriver()->getLastName(),
                    'idNumber' => $movement->getDriver()->getIdNumber(),
                    'driverLicense' => $movement->getDriver()->getDriverLicense(),
                    'issueDate' => $movement->getDriver()->getDriverLicenseIsueDate(),
                    'expirationDate' => $movement->getDriver()->getDriverLicenseExpirationDate(),
                    'postalCode' => $movement->getDriver()->getPostalCode(),
                    'address' => $movement->getDriver()->getAddress(),
                    'city' => $movement->getDriver()->getCity(),
                    'state' => [
                        'id' => null,
                        'name' => $movement->getDriver()->getState(),
                    ],
                    'country' => [
                        'id' => $movement->getDriver()->getCountry() ? $movement->getDriver()->getCountry()->getId() : null,
                        'name' => $movement->getDriver()->getCountry() ? $movement->getDriver()->getCountry()->getName() : null,
                        'iso' => $movement->getDriver()->getCountry() ? $movement->getDriver()->getCountry()->getISO() : null,
                    ],
                    'branch' => [
                        'id' => $movement->getDriver()->getBranchId(),
                        'name' => null,
                    ],
                    'provider' => [
                        'id' => $movement->getDriver()->getProviderId(),
                        'name' => null,
                    ],
                ]
                : [];

            // Obtenemos un vehículo en movimiento por conductor
            if (!empty($movement->getVehicleLineCollection()) && $movement->getVehicleLineCollection()->count() > 0) {

                /**
                 * @var VehicleLine $vehicleLine
                 */
                $vehicleLine = $movement->getVehicleLineCollection()[0];

                $vehicle = [
                    'id' =>  $vehicleLine->getVehicle()->getId(),
                    'licensePlate' => $vehicleLine->getVehicle()->getLicensePlate(),
                    'vin' =>  $vehicleLine->getVehicle()->getVin(),
                    'carClass' => ($vehicleLine->getVehicle()->getCarClass()) ? [
                        'id' =>  $vehicleLine->getVehicle()->getCarClass()->getId(),
                        'name' =>  $vehicleLine->getVehicle()->getCarClass()->getName(),
                    ] : null,
                    'vehicleGroup' => ($vehicleLine->getVehicle()->getCarGroup()) ? [
                        'id' => $vehicleLine->getVehicle()->getCarGroup()->getId(),
                        'name' => $vehicleLine->getVehicle()->getCarGroup()->getName(),
                    ] : null,
                    'acriss' => ($vehicleLine->getVehicle()->getAcriss()) ? [
                        'id' => $vehicleLine->getVehicle()->getAcriss()->getId(),
                        'name' => $vehicleLine->getVehicle()->getAcriss()->getName(),
                    ] : null,
                    'actualKms' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getKilometersActual() : null,
                    'brand' => ($vehicleLine->getVehicle()->getBrand()) ? [
                        'id' => $vehicleLine->getVehicle()->getBrand()->getId(),
                        'name' => $vehicleLine->getVehicle()->getBrand()->getName(),
                    ] : null,
                    'model' => ($vehicleLine->getVehicle()->getModel()) ? [
                        'id' => $vehicleLine->getVehicle()->getModel()->getId(),
                        'name' => $vehicleLine->getVehicle()->getModel()->getName(),
                    ] : null,
                    'trim' => $vehicleLine->getVehicle()->getTrimName(),
                    'status' => ($vehicleLine->getVehicle()->getStatus()) ? [
                        'id' => $vehicleLine->getVehicle()->getStatus()->getId(),
                        'name' => $vehicleLine->getVehicle()->getStatus()->getName(),
                    ] : null,
                    'rentingEndDate' => $vehicleLine->getVehicle()->getRentingEndDate() ? $vehicleLine->getVehicle()->getRentingEndDate()->__toString() : null,
                    'region' => ($vehicleLine->getVehicle()->getRegion()) ? [
                        'id' => $vehicleLine->getVehicle()->getRegion()->getId(),
                        'name' => $vehicleLine->getVehicle()->getRegion()->getName(),
                    ] : null,
                    'area' => ($vehicleLine->getVehicle()->getArea()) ? [
                        'id' => $vehicleLine->getVehicle()->getArea()->getId(),
                        'name' => $vehicleLine->getVehicle()->getArea()->getName(),
                    ] : null,
                    'branch' => ($vehicleLine->getVehicle()->getBranch()) ? [
                        'id' => $vehicleLine->getVehicle()->getBranch()->getId(),
                        'name' => $vehicleLine->getVehicle()->getBranch()->getName(),
                    ] : null,
                    'location' => ($vehicleLine->getVehicle()->getLocation()) ? [
                        'id' => $vehicleLine->getVehicle()->getLocation()->getId(),
                        'name' => $vehicleLine->getVehicle()->getLocation()->getName(),
                    ] : null,
                ];
            }
        }


        /**
         * Vehicle lines & filters CARRIER, OPERATION
         */
        if (in_array($movement->getMovementType()->getId(), [ConstantsJsonFile::getValue("TRANSPORTTYPE_CARRIER"), ConstantsJsonFile::getValue("TRANSPORTTYPE_OPERATION")])) {
            if (!empty($movement->getVehicleLineCollection())) {
                foreach ($movement->getVehicleLineCollection() as $key => $vehicleLine) {
                    $vehicleLineList[] = [
                        'brandName' => $vehicleLine->getVehicle() && $vehicleLine->getVehicle()->getBrand() ? $vehicleLine->getVehicle()->getBrand()->getName() : null,
                        'modelName' => $vehicleLine->getVehicle() && $vehicleLine->getVehicle()->getModel() ?  $vehicleLine->getVehicle()->getModel()->getName() : null,
                        'licensePlate' => $vehicleLine->getVehicle() ? $vehicleLine->getVehicle()->getLicensePlate() : null,
                        'kilometersActual' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getKilometersActual() : null,
                        'batteryActual' => $vehicleLine->getVehicleRecordsLoad() ? $vehicleLine->getVehicleRecordsLoad()->getBatteryActual() : null,
                        'vehicleStatus' => $vehicleLine->getVehicle() && $vehicleLine->getVehicle()->getStatus() ? $vehicleLine->getVehicle()->getStatus()->getName() : null,
                        'trimName' => $vehicleLine->getVehicle()->getTrimName(),
                        'saleMethodId' => $vehicleLine->getVehicle() && $vehicleLine->getVehicle()->getSaleMethod() ? $vehicleLine->getVehicle()->getSaleMethod()->getId() : null,
                        'actualLoadDate' => $vehicleLine->getActualLoadDate() ? $vehicleLine->getActualLoadDate()->__toString() : null,
                        'actualUnloadDate' => $vehicleLine->getActualUnloadDate() ? $vehicleLine->getActualUnloadDate()->__toString() : null,
                    ];
                }
            }

            if (!empty($movement->getVehicleFilterCollection())) {

                // FIXME los filtros no son una colección, son un objeto. Modificar estructura
                foreach ($movement->getVehicleFilterCollection() as $key => $vehicleFilter) {
                    $vehicleFilter = [
                        'vehicleType' => $vehicleFilter->getVehicleTypeCollection()->toArray(),
                        'brand' => $vehicleFilter->getBrandCollection()->toArray(),
                        'model' => $vehicleFilter->getModelCollection()->toArray(),
                        'carGroup' => $vehicleFilter->getCarGroupCollection()->toArray(),
                        'kilometersFrom' => $vehicleFilter->getKilometersFrom(),
                        'kilometersTo' => $vehicleFilter->getKilometersTo(),
                        'rentingEndDateFrom' => $vehicleFilter->getRentingEndDateFrom(),
                        'rentingEndDateTo' => $vehicleFilter->getRentingEndDateTo(),
                        'checkInDateFrom' => $vehicleFilter->getCheckInDateFrom(),
                        'saleMethod' => $vehicleFilter->getSaleMethodCollection()->toArray(),
                        'vehicleStatus' => $vehicleFilter->getVehicleStatusCollection()->toArray(),
                        'connectedVehicle' => $vehicleFilter->isConnectedVehicle(),
                    ];
                }

                // Bloqueo de filtros que coincidan con los datos de vehículos cargados
                $vehicles = array_map(
                    function ($vehicleLine) {
                        return $vehicleLine->getVehicle();
                    },
                    array_filter($movement->getVehicleLineCollection()->toArray(), function ($vehicleLine) {
                        return $vehicleLine->getActualLoadDate() !== null;
                    })
                );

                $vehicleFilter = [
                    'vehicleType' => array_map(
                        function ($filter) use ($vehicles) {
                            $vehicleTypeIds = array_map(
                                function ($vehicle) {
                                    return $vehicle->getType()->getId();
                                },
                                $vehicles
                            );
                            return [
                                'id' => $filter->getId(),
                                'name' => $filter->getName(),
                                'disabled' => in_array($filter->getId(), $vehicleTypeIds, true),
                            ];
                        },
                        $vehicleFilter['vehicleType']
                    ),

                    'brand' => array_map(
                        function ($filter) use ($vehicles) {
                            $brandIds = array_map(
                                function ($vehicle) {
                                    return $vehicle->getBrand()->getId();
                                },
                                $vehicles
                            );
                            return [
                                'id' => $filter->getId(),
                                'name' => $filter->getName(),
                                'disabled' => in_array($filter->getId(), $brandIds, true),
                            ];
                        },
                        $vehicleFilter['brand']
                    ),

                    'model' => array_map(
                        function ($filter) use ($vehicles) {
                            $modelIds = array_map(
                                function ($vehicle) {
                                    return $vehicle->getModel()->getId();
                                },
                                $vehicles
                            );
                            return [
                                'id' => $filter->getId(),
                                'name' => $filter->getName(),
                                'disabled' => in_array($filter->getId(), $modelIds, true),
                            ];
                        },
                        $vehicleFilter['model']
                    ),

                    'carGroup' => array_map(
                        function ($filter) use ($vehicles) {
                            $carGroupIds = array_map(
                                function ($vehicle) {
                                    return $vehicle->getCarGroup()->getId();
                                },
                                $vehicles
                            );
                            return [
                                'id' => $filter->getId(),
                                'name' => $filter->getName(),
                                'disabled' => in_array($filter->getId(), $carGroupIds, true),
                            ];
                        },
                        $vehicleFilter['carGroup']
                    ),

                    'kilometersFrom' => [
                        'value' => $vehicleFilter['kilometersFrom'],
                        'disabled' => count(array_filter(
                            array_map(
                                function ($vehicle) {
                                    return $vehicle->getActualKms();
                                },
                                $vehicles
                            ),
                            function ($km) use ($vehicleFilter) {
                                return $km >= $vehicleFilter['kilometersFrom'];
                            }
                        )) > 0,
                    ],
                    'kilometersTo' => [
                        'value' => $vehicleFilter['kilometersTo'],
                        'disabled' => count(array_filter(
                            array_map(
                                function ($vehicle) {
                                    return $vehicle->getActualKms();
                                },
                                $vehicles
                            ),
                            function ($km) use ($vehicleFilter) {
                                return $km <= $vehicleFilter['kilometersTo'];
                            }
                        )) > 0,
                    ],

                    'rentingEndDateFrom' => [
                        'value' => $vehicleFilter['rentingEndDateFrom'],
                        'disabled' => count(array_filter(
                            array_map(
                                function ($vehicle) {
                                    return $vehicle->getRentingEndDate();
                                },
                                $vehicles
                            ),
                            function ($date) use ($vehicleFilter) {
                                return $date >= $vehicleFilter['rentingEndDateFrom'];
                            }
                        )) > 0,
                    ],
                    'rentingEndDateTo' => [
                        'value' => $vehicleFilter['rentingEndDateTo'],
                        'disabled' => count(array_filter(
                            array_map(
                                function ($vehicle) {
                                    return $vehicle->getRentingEndDate();
                                },
                                $vehicles
                            ),
                            function ($date) use ($vehicleFilter) {
                                return $date <= $vehicleFilter['rentingEndDateTo'];
                            }
                        )) > 0,
                    ],

                    'checkInDateFrom' => [
                        'value' => $vehicleFilter['checkInDateFrom'],
                        'disabled' => count(array_filter(
                            array_map(
                                function ($vehicle) {
                                    return $vehicle->getCheckInDate();
                                },
                                $vehicles
                            ),
                            function ($date) use ($vehicleFilter) {
                                return $date >= $vehicleFilter['checkInDateFrom'];
                            }
                        )) > 0,
                    ],

                    'saleMethod' => array_map(
                        function ($filter) use ($vehicles) {
                            $saleMethodIds = array_map(
                                function ($vehicle) {
                                    return $vehicle->getSaleMethod()->getId();
                                },
                                $vehicles
                            );
                            return [
                                'id' => $filter->getId(),
                                'name' => $filter->getName(),
                                'disabled' => in_array($filter->getId(), $saleMethodIds, true),
                            ];
                        },
                        $vehicleFilter['saleMethod']
                    ),

                    'vehicleStatus' => array_map(
                        function ($filter) use ($vehicles) {
                            $vehicleStatusIds = array_map(
                                function ($vehicle) {
                                    return $vehicle->getStatus()->getId();
                                },
                                $vehicles
                            );
                            return [
                                'id' => $filter->getId(),
                                'name' => $filter->getName(),
                                'disabled' => in_array($filter->getId(), $vehicleStatusIds, true),
                            ];
                        },
                        $vehicleFilter['vehicleStatus']
                    ),

                    'connectedVehicle' => [
                        'value' => $vehicleFilter['connectedVehicle'],
                        'disabled' => $vehicleFilter['connectedVehicle'] !== null &&
                            in_array(
                                $vehicleFilter['connectedVehicle'],
                                array_map(
                                    function ($vehicle) {
                                        return $vehicle->isConnected();
                                    },
                                    $vehicles
                                ),
                                true
                            ),
                    ],
                ];

                /**
                 * Coincidir items bloqueados en los listados de selectores para filtros.
                 * Si no se aplica, los selects de Vue no identifican los items seleccionados, porque falta la propiedad 'disabled' en el objeto.
                 */
                foreach ($vehicleTypeList as &$vehicleType) {
                    foreach ($vehicleFilter['vehicleType'] as $item) {
                        if ($vehicleType['id'] === $item['id']) {
                            $vehicleType['disabled'] = $item['disabled'];
                            break;
                        } else {
                            $vehicleType['disabled'] = false;
                        }
                    }
                }
                foreach ($vehicleStatusList as &$vehicleStatus) {
                    foreach ($vehicleFilter['vehicleStatus'] as $item) {
                        if ($vehicleStatus['id'] === $item['id']) {
                            $vehicleStatus['disabled'] = $item['disabled'];
                            break;
                        } else {
                            $vehicleStatus['disabled'] = false;
                        }
                    }
                }
                foreach ($brandList as &$brand) {
                    foreach ($vehicleFilter['brand'] as $item) {
                        if ($brand['id'] === $item['id']) {
                            $brand['disabled'] = $item['disabled'];
                            break;
                        } else {
                            $brand['disabled'] = false;
                        }
                    }
                }
                foreach ($modelList as &$model) {
                    foreach ($vehicleFilter['model'] as $item) {
                        if ($model['id'] === $item['id']) {
                            $model['disabled'] = $item['disabled'];
                            break;
                        } else {
                            $model['disabled'] = false;
                        }
                    }
                }
                foreach ($carGroupList as &$carGroup) {
                    foreach ($vehicleFilter['carGroup'] as $item) {
                        if ($carGroup['id'] === $item['id']) {
                            $carGroup['disabled'] = $item['disabled'];
                            break;
                        } else {
                            $carGroup['disabled'] = false;
                        }
                    }
                }
                foreach ($saleMethodList as &$saleMethod) {
                    foreach ($vehicleFilter['saleMethod'] as $item) {
                        if ($saleMethod['id'] === $item['id']) {
                            $saleMethod['disabled'] = $item['disabled'];
                            break;
                        } else {
                            $saleMethod['disabled'] = false;
                        }
                    }
                }
                /* */
            }
        }


        // Fase de diseño de datos
        // FIXME refactorizar cuando se cambie el response de WS
        $movementArray = [
            'id' => $movement->getId(),
            'movementTypeId' => $movement->getMovementType()->getId(),
            'movementCategory' => $movement->getMovementType()->getId() === intval(ConstantsJsonFile::getValue("TRANSPORTTYPE_DRIVER")) ? [
                'id' =>  $movement->getMovementCategory()->getId(),
                'name' => $movement->getMovementCategory()->getName(),
            ] : [],
            'movementStatus' => ($movement->getMovementStatus()) ? [
                'id' => $movement->getMovementStatus()->getId(),
                'name' => $movement->getMovementStatus()->getName(),
            ] : null,
            'driverTypeId' => (!$movement->isExtTransport()) ? MovementConstants::MOVEMENT_DRIVER_TYPE_EMPLOYEE : MovementConstants::MOVEMENT_DRIVER_TYPE_PROVIDER,
            'extTransport' => $movement->isExtTransport(),
            'locationType' => ($movement->getOriginLocation() && $movement->getOriginLocation()->getLocationType()) ? [
                'id' =>  $movement->getOriginLocation()->getLocationType()->getId(),
                'name' => $movement->getOriginLocation()->getLocationType()->getName(),
            ] : null,
            'originLocation' => ($movement->getOriginLocation()) ? [
                'id' => $movement->getOriginLocation()->getId(),
                'name' => $movement->getOriginLocation()->getName(),
                'locationTypeId' => $movement->getOriginLocation()->getLocationType() ? $movement->getOriginLocation()->getLocationType()->getId() : null,
                'branchId' => $movement->getOriginLocation()->getBranch() ? $movement->getOriginLocation()->getBranch()->getId() : null,
            ] : null,
            'originExternalSupplier' => ($movement->getOriginExternalSupplier()) ? [
                'id' => $movement->getOriginExternalSupplier()->getId(),
                'name' => $movement->getOriginExternalSupplier()->getName(),
            ] : null,
            'originExternalLocation' => ($movement->getOriginExternalLocation()) ? [
                'id' => $movement->getOriginExternalLocation()->getId(),
                'name' => $movement->getOriginExternalLocation()->getName(),
                'branchId' => $movement->getOriginExternalLocation()->getBranch() ? $movement->getOriginExternalLocation()->getBranch()->getId() : null,
            ] : null,
            'manualOriginLocation' => ($movement->getManualOriginLocation()) ? [
                'countryId' => $movement->getManualOriginLocation()->getCountry()->getId(),
                'stateId' => $movement->getManualOriginLocation()->getState()->getId(),
                'notes' => $movement->getManualOriginLocation()->getNotes(),
            ] : null,
            'destinationLocation' => ($movement->getDestinationLocation()) ? [
                'id' => $movement->getDestinationLocation()->getId(),
                'name' => $movement->getDestinationLocation()->getName(),
                'locationTypeId' => $movement->getDestinationLocation()->getLocationType() ? $movement->getDestinationLocation()->getLocationType()->getId() : null,
                'branchId' => $movement->getDestinationLocation()->getBranch() ? $movement->getDestinationLocation()->getBranch()->getId() : null,
            ] : null,
            'destinationExternalSupplier' => ($movement->getDestinationExternalSupplier()) ? [
                'id' => $movement->getDestinationExternalSupplier()->getId(),
                'name' => $movement->getDestinationExternalSupplier()->getName(),
            ] : null,
            'destinationExternalLocation' => ($movement->getDestinationExternalLocation()) ? [
                'id' => $movement->getDestinationExternalLocation()->getId(),
                'name' => $movement->getDestinationExternalLocation()->getName(),
                'branchId' => $movement->getDestinationExternalLocation()->getBranch() ? $movement->getDestinationExternalLocation()->getBranch()->getId() : null,
            ] : null,
            'manualDestinationLocation' => ($movement->getManualDestinationLocation()) ? [
                'countryId' => $movement->getManualDestinationLocation()->getCountry()->getId(),
                'stateId' => $movement->getManualDestinationLocation()->getState()->getId(),
                'notes' => $movement->getManualDestinationLocation()->getNotes(),
            ] : null,
            'expectedLoadDate' => $movement->getExpectedLoadDate() ? $movement->getExpectedLoadDate()->__toString() : null,
            'actualLoadDate' => $movement->getActualLoadDate() ? $movement->getActualLoadDate()->__toString() : null,
            'expectedUnloadDate' => $movement->getExpectedUnloadDate() ? $movement->getExpectedUnloadDate()->__toString() : null,
            'actualUnloadDate' => $movement->getActualUnloadDate() ? $movement->getActualUnloadDate()->__toString() : null,
            'departmentId' => $movement->getDepartment() ? $movement->getDepartment()->getId() : null,
            'providerId' => $movement->getSupplier() ? $movement->getSupplier()->getId() : null,
            'businessUnit' => $movement->getBusinessUnit() ? [
                'id' => $movement->getBusinessUnit()->getId(), // Volvemos a insertar el 0 que eliminan desde WS
                'name' => $movement->getBusinessUnit()->getName(),
            ] : null,
            'businessUnitArticle' => $movement->getBusinessUnitArticle() ? [
                'id' => $movement->getBusinessUnitArticle()->getId(), // Volvemos a insertar el 0 que eliminan desde WS
                'name' => $movement->getBusinessUnitArticle()->getName(),
            ] : null,
            'transportMethodId' => $movement->getTransportMethod() ? $movement->getTransportMethod()->getId() : null,
            'vehicleUnits' => $movement->getVehicleUnits(),
            'manualCost' => $movement->getManualCost(),
            'automaticCost' => $movement->getAutomaticCost(),
            'notes' => $movement->getNotes(),
            'driver' => $driver,
            'vehicle' => $vehicle,
            'vehicleList' => $vehicleLineList,
            'vehicleFilters' => $vehicleFilter,
            'creationUser' => $movement->getCreationUser()->getName(),
            'creationDate' => $movement->getCreationDate()->__toString(),
            'editionUser' => $movement->getEditionUser() ? $movement->getEditionUser()->getName() : null,
            'editionDate' => $movement->getEditionDate() ? $movement->getEditionDate()->__toString() : null,
        ];

        $selectList = [
            'supplierList' => $supplierList,
            'movementCategoryList' => $movementCategoryList,
            'movementStatusList' => $movementStatusList,
            'transportMethodList' => $transportMethodList,
            'departmentList' => $departmentList,
            'businessUnitList' => $businessUnitList,
            'businessUnitArticleList' => $businessUnitArticleList,
            'locationList' => $locationList,
            'branchList' => $branchList,
            'countryList' => $countryList,
            'vehicleTypeList' => $vehicleTypeList,
            'vehicleStatusList' => $vehicleStatusList,
            'brandList' => $brandList,
            'modelList' => $modelList,
            'carGroupList' => $carGroupList,
            'saleMethodList' => $saleMethodList,
            'connectedVehicleList' => $connectedVehicleList,
        ];


        return new EditMovementResponse(
            $movement->getMovementType()->getId(),
            $movementArray,
            $selectList
        );
    }
}
