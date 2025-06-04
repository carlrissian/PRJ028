<?php

declare(strict_types=1);


namespace App\Constants;

use Distribution\MovementCategory\Domain\MovementCategory;

class MovementCategoryConstants extends Constants
{
    public const CATEGORY_MOVEMENT_ORDINARY = MovementCategory::ORDINARY;
    public const CATEGORY_MOVEMENT_NOT_ORDINARY = MovementCategory::NOT_ORDINARY;
    public const CATEGORY_MOVEMENT_INTERNAL = MovementCategory::INTERNAL;
}
