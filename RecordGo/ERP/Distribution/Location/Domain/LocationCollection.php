<?php
declare(strict_types=1);


namespace Distribution\Location\Domain;


use Shared\Domain\Collection;

class LocationCollection extends Collection
{
    protected function type(): string
    {
        return Location::class;
    }
}