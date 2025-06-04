<?php
declare(strict_types=1);

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

/**
 * Class StopSaleCollection
 * @method StopSale[] getIterator()
 */
class StopSaleCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return StopSale::class;
    }
}