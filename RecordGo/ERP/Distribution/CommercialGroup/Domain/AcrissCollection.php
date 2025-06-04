<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Domain;

use Shared\Domain\Collection;

class AcrissCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Acriss::class;
    }
}
