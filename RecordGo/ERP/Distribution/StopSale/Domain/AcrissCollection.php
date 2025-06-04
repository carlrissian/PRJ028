<?php
declare(strict_types=1);


namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

class AcrissCollection extends Collection
{

    protected function type(): string
    {
        return Acriss::class;
    }
}