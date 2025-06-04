<?php
declare(strict_types=1);


namespace Distribution\Vehicle\Domain;


use Shared\Domain\Collection;

class VehicleHistoryCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return VehicleHistory::class;
    }
}