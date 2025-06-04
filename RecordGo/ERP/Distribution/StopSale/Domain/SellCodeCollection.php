<?php
declare(strict_types=1);

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

class SellCodeCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return SellCode::class;
    }
}