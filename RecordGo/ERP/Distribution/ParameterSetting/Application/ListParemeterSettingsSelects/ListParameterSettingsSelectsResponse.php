<?php
declare(strict_types=1);


namespace Distribution\ParameterSetting\Application\ListParemeterSettingsSelects;


class ListParameterSettingsSelectsResponse
{
    /**
     * @var array
     */
    private array $carGroupList;
    /**
     * @var array
     */
    private array $acrissList;
    /**
     * @var array
     */
    private array $regions;
    /**
     * @var array
     */
    private array $areas;
    /**
     * @var array
     */
    private array $delegations;
    /**
     * @var array
     */
    private array $connectedVehicleList;
    /**
     * @var array
     */
    private array $parameterSettingTypeList;

    /**
     * @param array $carGroupList
     * @param array $acrissList
     * @param array $countries
     * @param array $regions
     * @param array $areas
     * @param array $delegations
     * @param array $connectedVehicleList
     * @param array $parameterSettingTypeList
     */
    public function __construct(array $carGroupList, array $acrissList, array $regions, array $areas, array $delegations, array $connectedVehicleList, array $parameterSettingTypeList)
    {
        $this->carGroupList = $carGroupList;
        $this->acrissList = $acrissList;
        $this->regions = $regions;
        $this->areas = $areas;
        $this->delegations = $delegations;
        $this->connectedVehicleList = $connectedVehicleList;
        $this->parameterSettingTypeList = $parameterSettingTypeList;
    }

    /**
     * @return array
     */
    public function getCarGroupList(): array
    {
        return $this->carGroupList;
    }

    /**
     * @return array
     */
    public function getAcrissList(): array
    {
        return $this->acrissList;
    }


    /**
     * @return array
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * @return array
     */
    public function getAreas(): array
    {
        return $this->areas;
    }

    /**
     * @return array
     */
    public function getDelegations(): array
    {
        return $this->delegations;
    }

    /**
     * @return array
     */
    public function getConnectedVehicleList(): array
    {
        return $this->connectedVehicleList;
    }

    /**
     * @return array
     */
    public function getParameterSettingTypeList(): array
    {
        return $this->parameterSettingTypeList;
    }


}
