<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Domain;

interface AcrissTranslationsRepository
{
    /**
     * @param AcrissTranslationsCriteria $criteria
     * @return AcrissTranslationsGetByResponse
     */
    // public function getBy(AcrissTranslationsCriteria $criteria): AcrissTranslationsGetByResponse;

    /**
     * @param AcrissTranslation $translation
     * @return integer
     */
    public function store(AcrissTranslation $translation): int;

    /**
     * @param AcrissTranslation $translation
     * @return integer
     */
    public function update(AcrissTranslation $translation): int;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
