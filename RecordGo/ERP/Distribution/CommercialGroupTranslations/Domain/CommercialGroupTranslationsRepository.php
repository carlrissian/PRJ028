<?php
declare(strict_types=1);

namespace Distribution\CommercialGroupTranslations\Domain;


interface CommercialGroupTranslationsRepository
{
    /**
     * @param int $id
     * @return TranslationsGetByResponse
     */
    public function getByCommercialGroupId(int $id): TranslationsGetByResponse;


    /**
     * @param Translation $translation
     * @return Translation
     */
    public function store(Translation $translation): Translation;

    /**
     * @param Translation $translation
     * @return Translation
     */
    public function update(Translation $translation): Translation;

    /**
     * @param int $id
     * @return Translation
     */
    public function delete(int $id): Translation;

}
