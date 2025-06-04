<?php

namespace Distribution\Vehicle\Domain;

use Shared\Domain\Collection;

class VehicleToUpdateCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return VehicleToUpdate::class;
    }
}
