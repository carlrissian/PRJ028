<?php
declare(strict_types=1);


namespace Distribution\StopSale\Domain;


use Shared\Domain\Collection;

class PartnerCollection extends Collection
{

    protected function type(): string
    {
        return Partner::class;
    }
}