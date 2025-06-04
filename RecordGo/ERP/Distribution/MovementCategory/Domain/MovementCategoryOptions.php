<?php
declare(strict_types=1);


namespace Distribution\MovementCategory\Domain;


use Shared\Domain\Enum;

class MovementCategoryOptions extends Enum
{
    public const CATEGORY_MOVEMENT_ORDINARY = 1;//ordinario
    public const CATEGORY_MOVEMENT_NOT_ORDINARY = 2;//no ordinario
    public const CATEGORY_MOVEMENT_INTERNAL = 3;//Interno
    protected function throwExceptionForInvalidValue($value)
    {
        // TODO: Implement throwExceptionForInvalidValue() method.
    }
}