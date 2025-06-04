<?php
declare(strict_types=1);


namespace Distribution\MovementStatus\Domain;


use Shared\Domain\Enum;

class MovementStatusOptions extends Enum
{
    public const MOVEMENT_STATUS_PENDING = 1;
    public const MOVEMENT_STATUS_IN_PROGRESS = 2;
    public const MOVEMENT_STATUS_FINALIZED = 3;
    public const MOVEMENT_STATUS_CANCELED = 4;

    protected function throwExceptionForInvalidValue($value)
    {
        // TODO: Implement throwExceptionForInvalidValue() method.
    }
}