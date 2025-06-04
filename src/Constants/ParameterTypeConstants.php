<?php
declare(strict_types=1);


namespace App\Constants;


use Distribution\ParameterSettingType\Domain\ParameterSettingTypeOptions;

class ParameterTypeConstants  extends Constants
{
    public const PARAMETER_TYPE_ORDER_UPGRADE = ParameterSettingTypeOptions::PARAMETER_TYPE_ORDER_UPGRADE;
    public const PARAMETER_TYPE_SALE_FAMILY = ParameterSettingTypeOptions::PARAMETER_TYPE_SALE_FAMILY;

    public const PARAMETER_TYPE_GROUP = ParameterSettingTypeOptions::PARAMETER_TYPE_GROUP;
}