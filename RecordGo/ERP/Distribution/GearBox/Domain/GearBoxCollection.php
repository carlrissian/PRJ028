<?php
declare(strict_types=1);


namespace Distribution\GearBox\Domain;


use Shared\Domain\Collection;

class GearBoxCollection extends Collection
{

    protected function type(): string
    {
        return GearBox::class;
    }
}