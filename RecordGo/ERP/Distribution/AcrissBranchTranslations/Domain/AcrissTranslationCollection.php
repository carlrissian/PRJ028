<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Domain;

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
