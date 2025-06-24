<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\CreateParameterSetting;

use Shared\Utils\Utils;
use Shared\Domain\Criteria\Filter;
use Doctrine\Common\Collections\Criteria;
use Distribution\Area\Domain\AreaCriteria;
use Shared\Domain\Criteria\FilterOperator;
use App\Constants\ConnectedVehicleConstants;
use Distribution\Acriss\Domain\Acriss;
use Distribution\Area\Domain\AreaRepository;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Region\Domain\RegionCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Partner\Domain\PartnerCriteria;
use Distribution\Region\Domain\RegionRepository;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\Partner\Domain\PartnerRepository;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeRepository;

class CreateParameterSettingQueryHandler
{
    /**
     * @var ParameterSettingTypeRepository
     */
    private ParameterSettingTypeRepository $parameterSettingTypeRepository;

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
     * @var PartnerRepository
     */
    private PartnerRepository $partnerRepository;

    /**
     * CreateParameterSettingQueryHandler constructor.
     *
     * @param ParameterSettingTypeRepository $parameterSettingTypeRepository
     * @param CarGroupRepository $carGroupRepository
     * @param AcrissRepository $acrissRepository
     * @param RegionRepository $regionRepository
     * @param AreaRepository $areaRepository
     * @param BranchRepository $branchRepository
     * @param PartnerRepository $partnerRepository
     */
    public function __construct(
        ParameterSettingTypeRepository $parameterSettingTypeRepository,
        CarGroupRepository $carGroupRepository,
        AcrissRepository $acrissRepository,
        RegionRepository $regionRepository,
        AreaRepository $areaRepository,
        BranchRepository $branchRepository,
        PartnerRepository $partnerRepository
    ) {
        $this->parameterSettingTypeRepository = $parameterSettingTypeRepository;
        $this->carGroupRepository = $carGroupRepository;
        $this->acrissRepository = $acrissRepository;
        $this->regionRepository = $regionRepository;
        $this->areaRepository = $areaRepository;
        $this->branchRepository = $branchRepository;
        $this->partnerRepository = $partnerRepository;
    }

    /**
     * @param CreateParameterSettingQuery $query
     * @return CreateParameterSettingResponse
     */
    public function handle(CreateParameterSettingQuery $query): CreateParameterSettingResponse
    {
        // TODO se va a filtrar por país (?)
        $countryId = $query->getCountryId();
        $countryFilterCollection = new FilterCollection([]);
        // $countryFilterCollection = new FilterCollection(
        //     [new Filter('COUNTRYID', new FilterOperator(FilterOperator::EQUAL), $countryId)]
        // );

        // FIXME mover esta lógica al frontend
        $parameterSettingTypeCollection = $this->parameterSettingTypeRepository->getBy(new Criteria())->getCollection();
        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria())->getCollection();
        $regionCollection = $this->regionRepository->getBy(new RegionCriteria($countryFilterCollection))->getCollection();
        $areaCollection = $this->areaRepository->getBy(new AreaCriteria($countryFilterCollection))->getCollection();
        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();
        $partnerCollection = $this->partnerRepository->getBy(new PartnerCriteria())->getCollection();

        $parameterSettingTypeList = Utils::createSelect($parameterSettingTypeCollection);
        $carGroupList = Utils::createSelect($carGroupCollection);
        $acrissList = Utils::createCustomSelectList($acrissCollection, 'id', 'name', 'carGroup.id');
        $regionList = Utils::createSelect($regionCollection);
        $areaList = Utils::createCustomSelectList($areaCollection, 'id', 'name', 'region.id');
        $branchList = Utils::createCustomSelectList($branchCollection, 'id', 'name', 'area.id');
        $partnerList = Utils::createSelect($partnerCollection);
        $connectedVehicleList = [
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_YES, 'name' => 'yes'],
            ['id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_NO, 'name' => 'no'],
        ];

        $selectList = [
            'parameterSettingTypeList' => $parameterSettingTypeList,
            'carGroupList' => $carGroupList,
            'acrissList' => $acrissList,
            'regionList' => $regionList,
            'areaList' => $areaList,
            'branchList' => $branchList,
            'partnerList' => $partnerList,
            'connectedVehicleList' => $connectedVehicleList,
        ];

        return new CreateParameterSettingResponse($selectList);
    }
}
