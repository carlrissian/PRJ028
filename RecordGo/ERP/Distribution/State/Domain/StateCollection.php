<?php

declare(strict_types=1);

namespace Distribution\State\Domain;

use Shared\Domain\Collection;

/**
 * Class StateCollection
 * @method State[] getIterator()
 */
class StateCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return State::class;
    }
}
