<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Domain;

interface ParameterSettingRepository
{
    /**
     * @param ParameterSettingCriteria $parameterSettingCriteria
     * @return ParameterSettingGetByResponse
     */
    public function getBy(ParameterSettingCriteria $parameterSettingCriteria): ParameterSettingGetByResponse;

    /**
     * @param ParameterSetting $parameterSetting
     * @return int
     */
    public function store(ParameterSetting $parameterSetting): int;

    /**
     * @param ParameterSettingCalendarCriteria $parameterSettingCriteria
     * @return ParameterSettingGetByResponse
     */
    public function getParameterSettingCalendarBy(ParameterSettingCalendarCriteria $parameterSettingCriteria): ParameterSettingGetByResponse;

     /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

