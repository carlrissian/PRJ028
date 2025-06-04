<?php
declare(strict_types=1);


namespace Distribution\BusinessUnit\Domain;


use Shared\Domain\Collection;

class BusinessUnitCollection extends Collection
{

    protected function type(): string
    {
        return BusinessUnit::class;
    }
}