<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\Collection;

/**
 * Class VehicleLineCollection
 * @method VehicleLine[] getIterator()
 */
class VehicleLineCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return VehicleLine::class;
    }
}