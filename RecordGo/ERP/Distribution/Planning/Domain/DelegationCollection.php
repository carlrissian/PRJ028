<?php
declare(strict_types=1);


namespace Distribution\Planning\Domain;


use Shared\Domain\Collection;

class DelegationCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Delegation::class;
    }
}