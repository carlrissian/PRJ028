<?php

namespace Distribution\Vehicle\Domain;

use Shared\Domain\Collection;

class VehicleImageCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return VehicleImage::class;
    }
}
