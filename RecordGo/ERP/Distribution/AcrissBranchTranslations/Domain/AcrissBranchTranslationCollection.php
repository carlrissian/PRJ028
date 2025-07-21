<?php

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Domain\Collection;

final class AcrissBranchTranslationCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return AcrissBranchTranslation::class;
    }
}
