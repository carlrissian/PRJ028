<?php

namespace Distribution\StopSale\Application\CreateStopSale;

use Shared\Utils\Utils;
use App\Constants\WeekDaysConstants;
use Distribution\Acriss\Domain\Acriss;
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
use Distribution\StopSaleType\Domain\StopSaleTypeCriteria;
use Distribution\StopSaleType\Domain\StopSaleTypeRepository;

final class CreateStopSaleQueryHandler
{
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
     * CreateStopSaleQueryHandler constructor.
     * 
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
     * @param CreateStopSaleQuery $query
     * @return CreateStopSaleResponse
     */
    public function handle(CreateStopSaleQuery $query): CreateStopSaleResponse
    {
        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria())->getCollection();
        $regionCollection = $this->regionRepository->getBy(new RegionCriteria())->getCollection();
        $areaCollection = $this->areaRepository->getBy(new AreaCriteria())->getCollection();
        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();
        $stopSaleTypeCollection = $this->stopSaleTypeRepository->getBy(new StopSaleTypeCriteria())->getCollection();
        $partnerCollection = $this->partnerRepository->getBy(new PartnerCriteria())->getCollection();
        $sellCodeCollection = $this->sellCodeRepository->getBy(new SellCodeCriteria())->getCollection();
        $productCollection = $this->productRepository->getBy(new ProductCriteria())->getCollection();

        $carGroupList = Utils::createSelect($carGroupCollection);
        $carGroupList = Utils::orderSelectList($carGroupList);

        // $acrissList = Utils::createCustomSelectList($acrissCollection, 'id', 'name', 'carGroup.id');
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
        $acrissList = Utils::orderSelectList($acrissList);

        $regionList = Utils::createSelect($regionCollection);
        $regionList = Utils::orderSelectList($regionList);

        $areaList = Utils::createCustomSelectList($areaCollection, 'id', 'name', 'region.id');
        $areaList = Utils::orderSelectList($areaList);

        $branchList = Utils::createCustomSelectList($branchCollection, 'id', 'name', 'area.id');
        $branchList = Utils::orderSelectList($branchList);

        $stopSaleTypeList = Utils::createSelect($stopSaleTypeCollection);
        $stopSaleTypeList = Utils::orderSelectList($stopSaleTypeList);

        $partnerList = Utils::createSelect($partnerCollection);
        $partnerList = Utils::orderSelectList($partnerList);

        $sellCodeList = Utils::createSelect($sellCodeCollection);
        $sellCodeList = Utils::orderSelectList($sellCodeList);

        // $productList = Utils::createCustomSelectList($productCollection, 'id', 'code', 'name', 'version');
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
        $productList = Utils::orderSelectList($productList);

        $connectedVehicleList = [
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_YES, 'name' => 'Sí'],
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_NO, 'name' => 'No'],
        ];

        $daysList = $this->createWeekDaySelect();

        $selectList = [
            'carGroupList' => $carGroupList,
            'acrissList' => $acrissList,
            'regionList' => $regionList,
            'areaList' => $areaList,
            'branchList' => $branchList,
            'stopSaleTypeList' => $stopSaleTypeList,
            'partnerList' => $partnerList,
            'sellCodeList' => $sellCodeList,
            'productList' => $productList,
            'connectedVehicleList' => $connectedVehicleList,
            'daysList' => $daysList,
            'canBeEditCreated' => true,
        ];


        return new CreateStopSaleResponse($selectList);
    }


    /**
     * @return array
     */
    private function createWeekDaySelect(): array
    {
        $daysList = [];

        $daysList[] = [
            'id' => WeekDaysConstants::MONDAY,
            'name' => 'Lunes'
        ];
        $daysList[] = [
            'id' => WeekDaysConstants::TUESDAY,
            'name' => 'Martes'
        ];
        $daysList[] = [
            'id' => WeekDaysConstants::WEDNESDAY,
            'name' => 'Miércoles'
        ];
        $daysList[] = [
            'id' => WeekDaysConstants::THURSDAY,
            'name' => 'Jueves'
        ];
        $daysList[] = [
            'id' => WeekDaysConstants::FRIDAY,
            'name' => 'Viernes'
        ];
        $daysList[] = [
            'id' => WeekDaysConstants::SATURDAY,
            'name' => 'Sábado'
        ];
        $daysList[] = [
            'id' => WeekDaysConstants::SUNDAY,
            'name' => 'Domingo'
        ];

        return $daysList;
    }
}
