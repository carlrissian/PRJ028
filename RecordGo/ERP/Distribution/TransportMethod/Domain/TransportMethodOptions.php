<?php
declare(strict_types=1);


namespace Distribution\TransportMethod\Domain;


use Shared\Domain\Enum;

class TransportMethodOptions extends Enum
{
    public const TRANSPORT_METHOD_MARITIME = 1;//maritimo
    public const TRANSPORT_METHOD_ROAD = 2;//carretera

    protected function throwExceptionForInvalidValue($value)
    {
        // TODO: Implement throwExceptionForInvalidValue() method.
    }
}