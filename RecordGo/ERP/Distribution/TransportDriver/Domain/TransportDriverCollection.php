<?php

namespace Distribution\TransportDriver\Domain;

use Shared\Domain\Collection;

/**
 * Class TransportDriverCollection
 * @method TransportDriver[] getIterator()
 */
class TransportDriverCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return TransportDriver::class;
    }
}
