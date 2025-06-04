<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;

/**
 * Class AssignedVehicleCollection
 * @method Delegation[] getIterator()
 */
use Shared\Domain\Collection;

class AssignedVehicleCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return AssignedVehicle::class;
    }
}