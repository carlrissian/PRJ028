<?php

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Domain\Collection;

final class AcrissTranslationCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return AcrissTranslation::class;
    }

    /**
     * @param array|null $acrissTranslationsArray
     * @return AcrissTranslationCollection
     */
    public static function createFromArray(?array $acrissTranslationsArray): self
    {
        $collection = new self([]);
        if (is_array($acrissTranslationsArray)) {
            foreach ($acrissTranslationsArray as $translationArray) {
                $collection->add(AcrissTranslation::createFromArray($translationArray));
            }
        }
        return $collection;
    }
}
