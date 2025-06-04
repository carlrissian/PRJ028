<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Domain;

use Shared\Domain\Collection;

class TranslationCollection extends Collection
{
    protected function type(): string
    {
        return Translation::class;
    }
}
