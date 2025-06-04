<?php
declare(strict_types=1);


namespace App\Constants;


use Distribution\Location\Domain\LocationOptions;

class LocationConstants extends Constants
{
    public const EXTERNAL_LOCATION = LocationOptions::EXTERNAL_LOCATION;
    public const EXTERNAL_LOCATION_NOT_LOCATION = LocationOptions::EXTERNAL_LOCATION_NOT_LOCATION;

}