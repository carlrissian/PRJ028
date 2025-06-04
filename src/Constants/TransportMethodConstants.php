<?php
declare(strict_types=1);


namespace App\Constants;


use Distribution\TransportMethod\Domain\TransportMethodOptions;

class TransportMethodConstants  extends Constants
{
    public const TRANSPORT_METHOD_MARITIME = TransportMethodOptions::TRANSPORT_METHOD_MARITIME;
    public const TRANSPORT_METHOD_ROAD = TransportMethodOptions::TRANSPORT_METHOD_ROAD;
}