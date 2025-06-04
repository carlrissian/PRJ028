<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\VehicleFilter;

use Shared\Domain\Collection;

class SaleMethodCollection extends Collection
{
    protected function type(): string
    {
        return SaleMethod::class;
    }
}
