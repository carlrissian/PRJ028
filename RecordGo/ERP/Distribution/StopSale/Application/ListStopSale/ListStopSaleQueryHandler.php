<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\ListStopSale;

use Shared\Utils\Utils;
use Distribution\Acriss\Domain\Acriss;
use Distribution\Product\Domain\Product;
use App\Constants\StopSaleStatusConstants;
use Distribution\Area\Domain\AreaCriteria;
use App\Constants\ConnectedVehicleConstants;
use Distribution\Area\Domain\AreaRepository;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Region\Domain\RegionCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Partner\Domain\PartnerCriteria;
use Distribution\Product\Domain\ProductCriteria;
use Distribution\Region\Domain\RegionRepository;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\Partner\Domain\PartnerRepository;
use Distribution\Product\Domain\ProductRepository;
use Distribution\SellCode\Domain\SellCodeCriteria;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\SellCode\Domain\SellCodeRepository;
use Distribution\Department\Domain\DepartmentCriteria;
use Distribution\Department\Domain\DepartmentRepository;
use Distribution\StopSaleType\Domain\StopSaleTypeCriteria;
use Distribution\StopSaleType\Domain\StopSaleTypeRepository;

class ListStopSaleQueryHandler
{
    /**
     * @var DepartmentRepository
     */
    private DepartmentRepository $departmentRepository;

    /**
     * @var CarGroupRepository
     */
    private CarGroupRepository $carGroupRepository;

    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

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
     * @var StopSaleTypeRepository
     */
    private StopSaleTypeRepository $stopSaleTypeRepository;

    /**
     * @var PartnerRepository
     */
    private PartnerRepository $partnerRepository;

    /**
     * @var SellCodeRepository
     */
    private SellCodeRepository $sellCodeRepository;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * ListStopSaleQueryHandler constructor.
     * 
     * @param DepartmentRepository $departmentRepository
     * @param CarGroupRepository $carGroupRepository
     * @param AcrissRepository $acrissRepository
     * @param RegionRepository $regionRepository
     * @param AreaRepository $areaRepository
     * @param BranchRepository $branchRepository
     * @param StopSaleTypeRepository $stopSaleTypeRepository
     * @param PartnerRepository $partnerRepository
     * @param SellCodeRepository $sellCodeRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(
        DepartmentRepository $departmentRepository,
        CarGroupRepository $carGroupRepository,
        AcrissRepository $acrissRepository,
        RegionRepository $regionRepository,
        AreaRepository $areaRepository,
        BranchRepository $branchRepository,
        StopSaleTypeRepository $stopSaleTypeRepository,
        PartnerRepository $partnerRepository,
        SellCodeRepository $sellCodeRepository,
        ProductRepository $productRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->carGroupRepository = $carGroupRepository;
        $this->acrissRepository = $acrissRepository;
        $this->regionRepository = $regionRepository;
        $this->areaRepository = $areaRepository;
        $this->branchRepository = $branchRepository;
        $this->stopSaleTypeRepository = $stopSaleTypeRepository;
        $this->partnerRepository = $partnerRepository;
        $this->sellCodeRepository = $sellCodeRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param ListStopSaleQuery $query
     * @return ListStopSaleResponse
     */
    final public function handle(ListStopSaleQuery $query): ListStopSaleResponse
    {
        $departmentCollection = $this->departmentRepository->getBy(new DepartmentCriteria())->getCollection();
        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria())->getCollection();
        $regionCollection = $this->regionRepository->getBy(new RegionCriteria())->getCollection();
        $areaCollection = $this->areaRepository->getBy(new AreaCriteria())->getCollection();
        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();
        $stopSaleTypeCollection = $this->stopSaleTypeRepository->getBy(new StopSaleTypeCriteria())->getCollection();
        $partnerCollection = $this->partnerRepository->getBy(new PartnerCriteria())->getCollection();
        $sellCodeCollection = $this->sellCodeRepository->getBy(new SellCodeCriteria())->getCollection();
        $productCollection = $this->productRepository->getBy(new ProductCriteria())->getCollection();

        $departmentList = Utils::createSelect($departmentCollection);
        $carGroupList = Utils::createSelect($carGroupCollection);
        usort($carGroupList, fn($a, $b) => strcasecmp($a['name'], $b['name']));

        // $acrissList = Utils::createCustomSelectList($acrissCollection, 'id', 'acrissName', 'carGroup.id');
        $acrissList = [];
        /**
         * @var Acriss $acriss
         */
        foreach ($acrissCollection as $acriss) {
            if ($acriss->getAcrissParentId() !== null) {
                continue;
            }

            $acrissList[] = [
                'id' => $acriss->getId(),
                'name' => $acriss->getName(),
                'carGroupId' => $acriss->getCarGroup() ? $acriss->getCarGroup()->getId() : null
            ];
        }
        usort($acrissList, fn($a, $b) => strcasecmp($a['name'], $b['name']));

        usort($acrissList, fn($a, $b) => strcasecmp($a['name'], $b['name']));
        $regionList = Utils::createSelect($regionCollection);
        $areaList = Utils::createSelect($areaCollection);
        $branchList = Utils::createSelect($branchCollection);
        $stopSaleTypeList = Utils::createSelect($stopSaleTypeCollection);
        $partnerList = Utils::createSelect($partnerCollection);
        usort($partnerList, fn($a, $b) => strcasecmp($a['name'], $b['name']));

        $sellCodeList = Utils::createSelect($sellCodeCollection);
        usort($sellCodeList, fn($a, $b) => strcasecmp($a['name'], $b['name']));
        // $productList = Utils::createSelect($productCollection);
        $productList = [];
        /**
         * @var Product $product
         */
        foreach ($productCollection as $product) {
            $productList[] = [
                'id' => $product->getId(),
                'code' => $product->getCodeName(),
                'name' => $product->getInternalName(),
                'version' => $product->getVersion(),
            ];
        }
        usort($productList, fn($a, $b) => strcasecmp($a['name'], $b['name']));
       
        $connectedVehicleList = [
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_YES, 'name' => 'Sí'],
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_NO, 'name' => 'No'],
        ];

        $selectList = [
            'departmentList' => $departmentList,
            'carGroupList' => $carGroupList,
            'acrissList' => $acrissList,
            'regionList' => $regionList,
            'areaList' => $areaList,
            'branchList' => $branchList,
            'stopSaleTypeList' => $stopSaleTypeList,
            'stopSaleStatusList' => [
                ['id' => StopSaleStatusConstants::STOPSALE_STATUS_ACTIVE, 'name' => StopSaleStatusConstants::STOPSALE_STATUS_ACTIVE_NAME],
                ['id' => StopSaleStatusConstants::STOPSALE_STATUS_CANCELED, 'name' => StopSaleStatusConstants::STOPSALE_STATUS_CANCELED_NAME],
                ['id' => StopSaleStatusConstants::STOPSALE_STATUS_FINISHED, 'name' => StopSaleStatusConstants::STOPSALE_STATUS_FINISHED_NAME]
            ],
            'partnerList' => $partnerList,
            'sellCodeList' => $sellCodeList,
            'productList' => $productList,
            'connectedVehicleList' => $connectedVehicleList,
        ];

        return new ListStopSaleResponse($selectList);
    }
}
