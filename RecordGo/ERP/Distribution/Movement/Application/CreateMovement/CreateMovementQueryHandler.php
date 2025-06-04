<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\CreateMovement;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use App\Constants\ConnectedVehicleConstants;
use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Model\Domain\ModelCriteria;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Brand\Domain\BrandException;
use Distribution\Model\Domain\ModelException;
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
use Distribution\Supplier\Domain\SupplierException;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\Location\Domain\LocationRepository;
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

class CreateMovementQueryHandler
{
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
     * CreateMovementQueryHandler constructor.
     *
     * @param MovementCategoryRepository $movementCategoryRepository
     * @param MovementStatusRepository $movementStatusRepository
     * @param TransportMethodRepository $transportMethodRepository
     * @param SupplierRepository $supplierRepository
     * @param DepartmentRepository $departmentRepository
     * @param BusinessUnitRepository $businessUnitRepository
     * @param BusinessUnitArticleRepository $businessUnitArticleRepository
     * @param LocationRepository $locationRepository
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
     * @param CreateMovementQuery $query
     * @return CreateMovementResponse
     *
     *  @throws MovementCategoryException
     *  @throws MovementStatusException
     *  @throws TransportMethodException
     *  @throws SupplierException
     *  @throws DepartmentException
     *  @throws BusinessUnitException
     *  @throws BusinessUnitArticleException
     *  @throws BranchException
     *  @throws CountryException
     *  @throws VehicleTypeNotFoundException
     *  @throws VehicleStatusNotFoundException
     *  @throws BrandException
     *  @throws ModelException
     *  @throws CarGroupException
     *  @throws SaleMethodNotFoundException
     */
    public function handle(CreateMovementQuery $query): CreateMovementResponse
    {
        $movementTypeId = $query->getMovementTypeId();

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

        switch ($movementTypeId) {
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
        $businessUnitArticleCollection = $this->businessUnitArticleRepository->getBy(
            new BusinessUnitArticleCriteria($filterCollection)
        )->getCollection();

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

        $resaleCodeCollection = $this->saleMethodRepository->getBy(new SaleMethodCriteria())->getCollection();
        if (empty($resaleCodeCollection)) {
            throw new SaleMethodNotFoundException('Error getting resale code');
        }


        $movementCategoryList = Utils::createSelect($movementCategoryCollection);
        $movementStatusList = Utils::createSelect($movementStatusCollection);
        $transportMethodList = Utils::createSelect($transportMethodCollection);
        $supplierList = Utils::createSelect($supplierCollection);
        $departmentList = Utils::createSelect($departmentCollection);
        $businessUnitList = Utils::createSelect($businessUnitCollection);

        // $businessUnitArticleList = [];
        // foreach ($businessUnitArticleCollection as $businessUnitArticle) {
        //     // foreach ($businessUnitArticle->getMovementTypeCollection() as $object) {
        //     //     if ($object->getId() === $query->getMovementTypeId()) {
        //     $businessUnitArticleList[] = [
        //         'id' => $businessUnitArticle->getId(),
        //         'name' => $businessUnitArticle->getName(),
        //     ];
        // }

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
        $saleMethodList = Utils::createSelect($resaleCodeCollection);

        $connectedVehicleList = [
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_YES, 'name' => 'Sí'],
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_NO, 'name' => 'No'],
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
//            'locationTypeList' => $locationTypeList,
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

        return new CreateMovementResponse($selectList);
    }
}
