<?php

namespace Distribution\AcrissBranchTranslations\Domain;

interface AcrissBranchTranslationsRepositoryInterface
{
    /**
     * @param AcrissBranchTranslationsCriteria $criteria
     * @return AcrissBranchTranslationsGetByResponse
     */
    public function getBy(AcrissBranchTranslationsCriteria $criteria): AcrissBranchTranslationsGetByResponse;

    /**
     * @param AcrissBranchTranslation $translation
     * @return integer
     */
    public function store(AcrissBranchTranslation $translation): int;

    /**
     * @param AcrissBranchTranslation $translation
     * @return integer
     */
    public function update(AcrissBranchTranslation $translation): int;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
