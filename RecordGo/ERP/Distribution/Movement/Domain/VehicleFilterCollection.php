<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\Collection;
/**
 * Class VehicleFilterCollection
 * @method VehicleFilter[] getIterator()
 */
class VehicleFilterCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return VehicleFilter::class;
    }
}