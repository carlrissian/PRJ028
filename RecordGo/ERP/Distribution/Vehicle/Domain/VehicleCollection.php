<?php
declare(strict_types=1);


namespace Distribution\Vehicle\Domain;


use Shared\Domain\Collection;

class VehicleCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return Vehicle::class;
    }
}