<?php

namespace Distribution\Damage\Domain;

use Shared\Domain\Collection;

class DamageCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Damage::class;
    }
}
