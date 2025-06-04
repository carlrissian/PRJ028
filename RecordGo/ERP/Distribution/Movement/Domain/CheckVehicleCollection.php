<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;

use Shared\Domain\Collection;

/**
 * Class CheckVehicleCollection
 * @method CheckVehicle[] getIterator()
 */
class CheckVehicleCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return CheckVehicle::class;
    }
}