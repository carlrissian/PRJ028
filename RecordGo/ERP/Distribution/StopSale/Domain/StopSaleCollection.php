<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

/**
 * Class StopSaleCollection
 * @method StopSale[] getIterator()
 */
final class StopSaleCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return StopSale::class;
    }
}
