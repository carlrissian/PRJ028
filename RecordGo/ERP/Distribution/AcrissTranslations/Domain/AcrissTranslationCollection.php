<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Domain;

use Shared\Domain\Collection;

class AcrissTranslationCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return AcrissTranslation::class;
    }
}
