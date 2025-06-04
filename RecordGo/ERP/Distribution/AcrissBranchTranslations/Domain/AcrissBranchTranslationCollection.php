<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Domain\Collection;

class AcrissBranchTranslationCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return AcrissBranchTranslation::class;
    }
}
