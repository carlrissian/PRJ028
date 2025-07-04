<?php

namespace Distribution\ParameterSetting\Application\ListParemeterSettingsSelects;

use Shared\Utils\Utils;
use Distribution\Area\Domain\AreaCriteria;
use App\Constants\ConnectedVehicleConstants;
use Distribution\Area\Domain\AreaRepository;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Region\Domain\RegionCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Region\Domain\RegionRepository;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\Country\Domain\CountryRepository;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeCriteria;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeRepositoryInterface;

class ListParameterSettingsSelectsQueryHandler
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
     * @var ParameterSettingTypeRepositoryInterface
     */
    private ParameterSettingTypeRepositoryInterface $parameterSettingTypeRepository;

    /**
     * @param CarGroupRepository $carGroupRepository
     * @param AcrissRepository $acrissRepository
     * @param RegionRepository $regionRepository
     * @param AreaRepository $areaRepository
     * @param BranchRepository $branchRepository
     * @param ParameterSettingTypeRepositoryInterface $parameterSettingTypeRepository
     */
    public function __construct(CarGroupRepository $carGroupRepository, AcrissRepository $acrissRepository, RegionRepository $regionRepository, AreaRepository $areaRepository, BranchRepository $branchRepository, ParameterSettingTypeRepositoryInterface $parameterSettingTypeRepository)
    {
        $this->carGroupRepository = $carGroupRepository;
        $this->acrissRepository = $acrissRepository;
        $this->regionRepository = $regionRepository;
        $this->areaRepository = $areaRepository;
        $this->branchRepository = $branchRepository;
        $this->parameterSettingTypeRepository = $parameterSettingTypeRepository;
    }


    final public function handle(ListParameterSettingsSelectsQuery $query): ListParameterSettingsSelectsResponse
    {
        // FIXME pendiente mover la carga de selectores al frontend
        $parameterSettingTypeCollection = $this->parameterSettingTypeRepository->getBy(new ParameterSettingTypeCriteria())->getCollection();
        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria())->getCollection();
        $regionCollection = $this->regionRepository->getBy(new RegionCriteria())->getCollection();
        $areaCollection = $this->areaRepository->getBy(new AreaCriteria())->getCollection();
        $branchCollection = $this->branchRepository->getBy(new BranchCriteria())->getCollection();

        $parameterSettingTypeList = Utils::createSelect($parameterSettingTypeCollection);
        $carGroupList = Utils::createSelect($carGroupCollection);
        usort($carGroupList, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        $acrissList = Utils::createCustomSelectList($acrissCollection, 'id', 'name', 'carGroup.id');
        usort($acrissList, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        $regionList = Utils::createSelect($regionCollection);
        usort($regionList, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        $areaList = Utils::createCustomSelectList($areaCollection, 'id', 'name', 'region.id');
        usort($areaList, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        $branchList = Utils::createCustomSelectList($branchCollection, 'id', 'name', 'area.id');
        usort($branchList, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
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
            'connectedVehicleList' => $connectedVehicleList,
        ];

        return new ListParameterSettingsSelectsResponse($selectList);
    }
}
