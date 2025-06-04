<?php
declare(strict_types=1);


namespace Distribution\StopSale\Domain;


use Shared\Domain\Collection;
/**
 * Class RegionCollection
 * @method Region[] getIterator()
 */
class RegionCollection extends Collection
{

    protected function type(): string
    {
        return Region::class;
    }
}