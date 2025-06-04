<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

/**
 * Class ProductCollection
 * @method Product[] getIterator()
 */
class ProductCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Product::class;
    }
}
