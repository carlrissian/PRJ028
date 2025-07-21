<?php

namespace Distribution\AcrissBranchTranslations\Domain;

use Shared\Domain\Collection;

final class AcrissImageLineCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return AcrissImageLine::class;
    }

    /**
     * @param array|null $acrissImageLinesArray
     * @return self
     */
    public static function createFromArray(?array $acrissImageLinesArray): self
    {
        $collection = new self([]);
        if (is_array($acrissImageLinesArray)) {
            foreach ($acrissImageLinesArray as $imageLineArray) {
                $collection->add(AcrissImageLine::createFromArray($imageLineArray));
            }
        }
        return $collection;
    }
}
