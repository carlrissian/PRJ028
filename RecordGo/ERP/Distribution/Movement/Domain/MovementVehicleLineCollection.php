<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain;


use Shared\Domain\Collection;

/**
 * Class MovementVehicleLineCollection
 * @method MovementVehicleLine[] getIterator()
 */
class MovementVehicleLineCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return MovementVehicleLine::class;
    }
}