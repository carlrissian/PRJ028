<?php
declare(strict_types=1);


namespace Distribution\Language\Domain;



interface LanguageRepository
{
    /**
     * @param LanguageCriteria $languageCriteria
     * @return LanguageGetByResponse
     */
    public function getBy(LanguageCriteria $languageCriteria): LanguageGetByResponse;

}