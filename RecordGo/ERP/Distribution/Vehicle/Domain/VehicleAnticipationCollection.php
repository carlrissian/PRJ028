<?php

namespace Distribution\Vehicle\Domain;

use Shared\Domain\Collection;

class VehicleAnticipationCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return VehicleAnticipation::class;
    }
}
