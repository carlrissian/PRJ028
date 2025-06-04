<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain\VehicleFilter;


use Shared\Domain\Collection;

class VehicleStatusCollection extends Collection
{
    protected function type(): string
    {
        return VehicleStatus::class;
    }
}