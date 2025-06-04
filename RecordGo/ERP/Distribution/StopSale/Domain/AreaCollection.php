<?php
declare(strict_types=1);


namespace Distribution\StopSale\Domain;


use Shared\Domain\Collection;

class AreaCollection extends Collection
{

    protected function type(): string
    {
        return Area::class;
    }
}