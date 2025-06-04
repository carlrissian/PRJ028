<?php
declare(strict_types=1);


namespace Distribution\StopSaleType\Domain;


use Shared\Domain\Collection;

class StopSaleTypeCollection extends Collection {

    protected function type(): string
    {
        return StopSaleType::class;
    }
}