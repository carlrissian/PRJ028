<?php

namespace Distribution\SellCode\Domain;

use Shared\Domain\Collection;

/**
 * Class SellCodeCollection
 * @method SellCode[] getIterator()
 */
class SellCodeCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return SellCode::class;
    }
}
