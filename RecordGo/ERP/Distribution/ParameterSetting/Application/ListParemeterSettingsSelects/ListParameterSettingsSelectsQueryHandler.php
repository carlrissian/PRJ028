<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\ListParemeterSettingsSelects;

use Shared\Utils\Utils;
use Doctrine\Common\Collections\Criteria;
use Distribution\Area\Domain\AreaCriteria;
use App\Constants\ConnectedVehicleConstants;
use Distribution\Area\Domain\AreaRepository;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Region\Domain\RegionCriteria;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Region\Domain\RegionRepository;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\Country\Domain\CountryRepository;
use Distribution\CarGroup\Domain\CarGroupRepository;
use Distribution\ParameterSettingType\Domain\ParameterSettingTypeRepository;

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
     * @var CountryRepository
     */
    private CountryRepository $countryRepository;
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
     * @var ParameterSettingTypeRepository
     */
    private ParameterSettingTypeRepository $parameterSettingTypeRepository;

    /**
     * @param CarGroupRepository $carGroupRepository
     * @param AcrissRepository $acrissRepository
     * @param CountryRepository $countryRepository
     * @param RegionRepository $regionRepository
     * @param AreaRepository $areaRepository
     * @param BranchRepository $branchRepository
     * @param ParameterSettingTypeRepository $parameterSettingTypeRepository
     */
    public function __construct(
        CarGroupRepository $carGroupRepository,
        AcrissRepository $acrissRepository,
        CountryRepository $countryRepository,
        RegionRepository $regionRepository,
        AreaRepository $areaRepository,
        BranchRepository $branchRepository,
        ParameterSettingTypeRepository $parameterSettingTypeRepository
    ) {
        $this->carGroupRepository = $carGroupRepository;
        $this->acrissRepository = $acrissRepository;
        $this->countryRepository = $countryRepository;
        $this->regionRepository = $regionRepository;
        $this->areaRepository = $areaRepository;
        $this->branchRepository = $branchRepository;
        $this->parameterSettingTypeRepository = $parameterSettingTypeRepository;
    }


    final public function handle(ListParameterSettingsSelectsQuery $selectedParameterSettingsQuery): ListParameterSettingsSelectsResponse
    {
        $countryId = $selectedParameterSettingsQuery->getCountryId();

        $carGroup = $this->carGroupRepository->getBy(new CarGroupCriteria());

        $region = $this->regionRepository->getBy(new RegionCriteria(new FilterCollection([])));
        $area = $this->areaRepository->getBy(new AreaCriteria(new FilterCollection([])));
        $branch = $this->branchRepository->getBy(new BranchCriteria(new FilterCollection([])));
        /*$region = $this->regionRepository->getBy(new RegionCriteria(new FilterCollection([new Filter('countryId', new FilterOperator(FilterOperator::EQUAL), $countryId)])));
        $area = $this->areaRepository->getBy(new AreaCriteria(new FilterCollection([new Filter('countryId', new FilterOperator(FilterOperator::EQUAL), $countryId)])));
        $branch = $this->branchRepository->getBy(new BranchCriteria(new FilterCollection([new Filter('countryId', new FilterOperator(FilterOperator::EQUAL), $countryId)])));*/

        $acriss = $this->acrissRepository->getBy(new AcrissCriteria());

        $connectedVehicleList = [];
        $connectedVehicleList[] = [
            'id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_YES,
            'name' => 'Si'
        ];
        $connectedVehicleList[] = [
            'id' => ConnectedVehicleConstants::CONNECTED_VEHICLE_NO,
            'name' => 'No'
        ];

        $parameterSettingType = $this->parameterSettingTypeRepository->getBy(new Criteria());
        return new ListParameterSettingsSelectsResponse(
            Utils::createSelect($carGroup->getCollection()),
            Utils::createCustomSelectList($acriss->getCollection(), 'id', 'name', 'carGroup.id'),
            Utils::createSelect($region->getCollection()),
            Utils::createSelect($area->getCollection()),
            Utils::createSelect($branch->getCollection()),
            $connectedVehicleList,
            Utils::createSelect($parameterSettingType->getCollection())
        );
    }
}
