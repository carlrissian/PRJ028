<?php
declare(strict_types=1);


namespace Distribution\ParameterSettingType\Domain;


use Shared\Domain\Enum;

class ParameterSettingTypeOptions  extends Enum
{
    public const PARAMETER_TYPE_GROUP             = 1;
    public const PARAMETER_TYPE_ORDER_UPGRADE     = 2;
    public const PARAMETER_TYPE_SALE_FAMILY       = 3;

    protected function throwExceptionForInvalidValue($value)
    {
        // TODO: Implement throwExceptionForInvalidValue() method.
    }
}