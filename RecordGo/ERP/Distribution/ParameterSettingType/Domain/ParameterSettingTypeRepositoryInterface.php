<?php

namespace Distribution\ParameterSettingType\Domain;

interface ParameterSettingTypeRepositoryInterface
{
    /**
     * @param ParameterSettingTypeCriteria $criteria
     * @return ParameterSettingTypeGetByResponse
     */
    public function getBy(ParameterSettingTypeCriteria $criteria): ParameterSettingTypeGetByResponse;
}
