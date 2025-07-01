<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\IndexVehicle;

use Shared\Utils\Utils;
use Distribution\Acriss\Domain\Acriss;
use Distribution\Area\Domain\AreaCriteria;
use Distribution\Trim\Domain\TrimCriteria;
use Distribution\Area\Domain\AreaRepository;
use Distribution\Brand\Domain\BrandCriteria;
use Distribution\Model\Domain\ModelCriteria;
use Distribution\Trim\Domain\TrimRepository;
use Distribution\Brand\Domain\BrandException;
use Distribution\Model\Domain\ModelException;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Brand\Domain\BrandRepository;
use Distribution\Model\Domain\ModelRepository;
use Distribution\Region\Domain\RegionCriteria;
use Distribution\Branch\Domain\BranchException;
use Distribution\Vehicle\Domain\VehicleColumns;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\GearBox\Domain\GearBoxCriteria;
use Distribution\Region\Domain\RegionRepository;
use Distribution\CarClass\Domain\CarClassCriteria;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\GearBox\Domain\GearBoxRepository;
use Distribution\Location\Domain\LocationCriteria;
use Distribution\CarClass\Domain\CarClassException;
use Distribution\CarGroup\Domain\CarGroupException;
use Distribution\Location\Domain\LocationException;
use Distribution\Trim\Domain\TrimNotFoundException;
use Distribution\CarClass\Domain\CarClassRepository;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\Location\Domain\LocationRepository;
use Distribution\Acriss\Domain\InvalidAcrissException;
use Distribution\SaleMethod\Domain\SaleMethodCriteria;
use Distribution\SaleMethod\Domain\SaleMethodRepository;
use Distribution\VehicleType\Domain\VehicleTypeCriteria;
use Distribution\GearBox\Domain\GearBoxNotFoundException;
use Distribution\VehicleType\Domain\VehicleTypeRepository;
use Distribution\VehicleStatus\Domain\VehicleStatusCriteria;
use Distribution\VehicleStatus\Domain\VehicleStatusRepository;
use Distribution\SaleMethod\Domain\SaleMethodNotFoundException;
use Distribution\VehicleType\Domain\VehicleTypeNotFoundException;
use Distribution\MotorizationType\Domain\MotorizationTypeCriteria;
use Distribution\MotorizationType\Domain\MotorizationTypeException;
use Distribution\MotorizationType\Domain\MotorizationTypeRepository;
use Distribution\Supplier\Domain\SupplierCriteria;
use Distribution\Supplier\Domain\SupplierRepository;
use Distribution\VehicleStatus\Domain\VehicleStatusNotFoundException;

class IndexVehicleQueryHandler
{
    /**
     * @var RegionRepository
     */
    private RegionRepository $regionRepository;

    /**
     * @var AreaRepository
     */
    private AreaRepository $areaRepository;

    /**
     * @var BranchRepository
     */
    private BranchRepository $branchRepository;

    /**
     * @var LocationRepository
     */
    private LocationRepository $locationRepository;
    /**
     * @var BrandRepository
     */
    private BrandRepository $brandRepository;

    /**
     * @var ModelRepository
     */
    private ModelRepository $modelRepository;

    /**
     * @var TrimRepository
     */
    private TrimRepository $trimRepository;

    /**
     * @var SupplierRepository
     */
    private SupplierRepository $providerRepository;

    /**
     * @var SaleMethodRepository
     */
    private SaleMethodRepository $saleMethodRepository;

    /**
     * @var CarClassRepository
     */
    private CarClassRepository $carClassRepository;

    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $carGroupRepository;

    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @var MotorizationTypeRepository
     */
    private MotorizationTypeRepository $motorizationTypeRepository;

    /**
     * @var GearBoxRepository
     */
    private GearBoxRepository $gearBoxRepository;

    /**
     * @var VehicleStatusRepository
     */
    private VehicleStatusRepository $vehicleStatusRepository;

    /**
     * @var VehicleTypeRepository
     */
    private VehicleTypeRepository $vehicleTypeRepository;

    /**
     * IndexVehicleQueryHandler constructor.
     * 
     * @param RegionRepository $regionRepository
     * @param AreaRepository $areaRepository
     * @param BranchRepository $branchRepository
     * @param LocationRepository $locationRepository
     * @param BrandRepository $brandRepository
     * @param ModelRepository $modelRepository
     * @param TrimRepository $trimRepository
     * @param SupplierRepository $providerRepository
     * @param SaleMethodRepository $saleMethodRepository
     * @param CarClassRepository $carClassRepository
     * @param CarGroupRepository $carGroupRepository
     * @param AcrissRepository $acrissRepository
     * @param MotorizationTypeRepository $motorizationTypeRepository
     * @param GearBoxRepository $gearBoxRepository
     * @param VehicleStatusRepository $vehicleStatusRepository
     * @param VehicleTypeRepository $vehicleTypeRepository
     */
    public function __construct(
        RegionRepository $regionRepository,
        AreaRepository $areaRepository,
        BranchRepository $branchRepository,
        LocationRepository $locationRepository,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        TrimRepository $trimRepository,
        SupplierRepository $providerRepository,
        SaleMethodRepository $saleMethodRepository,
        CarClassRepository $carClassRepository,
        CarGroupRepository $carGroupRepository,
        AcrissRepository $acrissRepository,
        MotorizationTypeRepository $motorizationTypeRepository,
        GearBoxRepository $gearBoxRepository,
        VehicleStatusRepository $vehicleStatusRepository,
        VehicleTypeRepository $vehicleTypeRepository
    ) {
        $this->regionRepository = $regionRepository;
        $this->areaRepository = $areaRepository;
        $this->branchRepository = $branchRepository;
        $this->locationRepository = $locationRepository;
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        $this->trimRepository = $trimRepository;
        $this->providerRepository = $providerRepository;
        $this->saleMethodRepository = $saleMethodRepository;
        $this->carClassRepository = $carClassRepository;
        $this->carGroupRepository = $carGroupRepository;
        $this->acrissRepository = $acrissRepository;
        $this->motorizationTypeRepository = $motorizationTypeRepository;
        $this->gearBoxRepository = $gearBoxRepository;
        $this->vehicleStatusRepository = $vehicleStatusRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
    }

    public function handler(IndexVehicleQuery $query): IndexVehicleResponse
    {
        // $regionCollection = $this->regionRepository->getBy(new RegionCriteria())->getCollection();
        // if (empty($regionCollection)) {
        //     throw new RegionException('Error getting region');
        // }

        // $areaCollection = $this->areaRepository->getBy(new AreaCriteria())->getCollection();
        // if (empty($areaCollection)) {
        //     throw new AreaException('Error getting area');
        // }

        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();
        if (empty($branchCollection)) {
            throw new BranchException('Error getting branch');
        }

        $locationCollection = $this->locationRepository->getBy(new LocationCriteria())->getCollection();
        if (empty($locationCollection)) {
            throw new LocationException('Error getting locations');
        }

        $brandCollection = $this->brandRepository->getBy(new BrandCriteria())->getCollection();
        if (empty($brandCollection)) {
            throw new BrandException('Error getting brand');
        }

        $modelCollection = $this->modelRepository->getBy(new ModelCriteria())->getCollection();
        if (empty($modelCollection)) {
            throw new ModelException('Error getting model');
        }

        $trimCollection = $this->trimRepository->getBy(new TrimCriteria())->getCollection();
        if (empty($trimCollection)) {
            throw new TrimNotFoundException('Error getting trim');
        }

        $providerCollection = $this->providerRepository->getBy(new SupplierCriteria())->getCollection();
        if (empty($providerCollection)) {
            throw new TrimNotFoundException('Error getting provider');
        }

        $saleMethodCollection = $this->saleMethodRepository->getBy(new SaleMethodCriteria())->getCollection();
        if (empty($saleMethodCollection)) {
            throw new SaleMethodNotFoundException('Error getting sale method');
        }

        $carClassCollection = $this->carClassRepository->getBy(new CarClassCriteria())->getCollection();
        if (empty($carClassCollection)) {
            throw new CarClassException('Error getting car class');
        }

        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        if (empty($carGroupCollection)) {
            throw new CarGroupException('Error getting vehicle group');
        }

        $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria())->getCollection();
        if (empty($acrissCollection)) {
            throw new InvalidAcrissException('Error getting acriss');
        }

        $motorizationTypeCollection = $this->motorizationTypeRepository->getBy(new MotorizationTypeCriteria())->getCollection();
        if (empty($motorizationTypeCollection)) {
            throw new MotorizationTypeException('Error getting motorization type');
        }

        $gearBoxCollection = $this->gearBoxRepository->getBy(new GearBoxCriteria())->getCollection();
        if (empty($gearBoxCollection)) {
            throw new GearBoxNotFoundException('Error getting gear box');
        }

        $vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection();
        if (empty($vehicleStatusCollection)) {
            throw new VehicleStatusNotFoundException('Error getting vehicle status');
        }

        $vehicleTypeCollection = $this->vehicleTypeRepository->getBy(new VehicleTypeCriteria())->getCollection();
        if (empty($vehicleTypeCollection)) {
            throw new VehicleTypeNotFoundException('Error getting vehicle type');
        }


        // $regionList = Utils::createSelect($regionCollection);
        // $areaList = Utils::createSelect($areaCollection);
        $branchList = Utils::createSelect($branchCollection);
        $locationList = Utils::createSelect($locationCollection);
        $brandList = Utils::createSelect($brandCollection);
        $modelList = Utils::createSelect($modelCollection);
        $trimList = Utils::createSelect($trimCollection);
        $providerList = Utils::createSelect($providerCollection);
        // $purchaseMethodList = Utils::createSelect($purchaseMethodCollection);
        $purchaseMethodList = [];
        $saleMethodList = Utils::createSelect($saleMethodCollection);
        $carClassList = Utils::createSelect($carClassCollection);
        $carGroupList = Utils::createSelect($carGroupCollection);
        $acrissList = Utils::createSelect($acrissCollection);
        $motorizationTypeList = Utils::createSelect($motorizationTypeCollection);
        $gearBoxList = Utils::createSelect($gearBoxCollection);
        $vehicleStatusList = Utils::createSelect($vehicleStatusCollection);
        $vehicleTypeList = Utils::createSelect($vehicleTypeCollection);

        $selectList = [
            // TODO ver filtros pendientes (NO MVP) https://recordgo.atlassian.net/wiki/spaces/DIS/pages/435716117/028.005.03+Listar+veh+culos
            /* NO MVP */
            // 'regionList' => $regionList,
            // 'areaList' => $areaList,
            // 'logisticsList' => Utils::createSelect($x->getCollection()),
            // 'assumedCostByList' => Utils::createSelect($y->getCollection()),
            /**/
            'branchList' => $branchList,
            'locationList' => $locationList,
            'brandList' => $brandList,
            'modelList' => $modelList,
            'trimList' => $trimList,
            'providerList' => $providerList,
            'purchaseMethodList' => $purchaseMethodList,
            'saleMethodList' => $saleMethodList,
            'carClassList' => $carClassList,
            'carGroupList' => $carGroupList,
            'acrissList' => $acrissList,
            'motorizationTypeList' => $motorizationTypeList,
            'gearBoxList' => $gearBoxList,
            'vehicleStatusList' => $vehicleStatusList,
            'vehicleTypeList' => $vehicleTypeList,
            'columnList' => (array)VehicleColumns::getColumns('Time'),
        ];

        return new IndexVehicleResponse($selectList);
    }
}
