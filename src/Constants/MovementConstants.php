<?php

declare(strict_types=1);

namespace App\Constants;

use Distribution\Movement\Domain\MovementType;
use Distribution\Movement\Domain\MovementCategory;

class MovementConstants extends Constants
{
    const MOVEMENT_TYPE_DRIVER = MovementType::DRIVER;
    const MOVEMENT_TYPE_CARRIER = MovementType::CARRIER;
    const MOVEMENT_TYPE_OPERATION = MovementType::OPERATION;

    const MOVEMENT_DRIVER_TYPE_EMPLOYEE = 1;
    const MOVEMENT_DRIVER_TYPE_PROVIDER = 0;

    const MOVEMENT_CATEGORY_ORDINARY = MovementCategory::ORDINARY;
    const MOVEMENT_CATEGORY_NOT_ORDINARY = MovementCategory::NOT_ORDINARY;
    const MOVEMENT_CATEGORY_INTERNAL = MovementCategory::INTERNAL;
}
