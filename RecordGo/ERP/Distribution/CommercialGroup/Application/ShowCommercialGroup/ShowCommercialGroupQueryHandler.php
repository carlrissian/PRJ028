<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\ShowCommercialGroup;

use Exception;
use Distribution\Language\Domain\Language;
use Distribution\Language\Domain\LanguageCriteria;
use Distribution\CommercialGroup\Domain\Translation;
use Distribution\Language\Domain\LanguageCollection;
use Distribution\Language\Domain\LanguageRepository;
use Distribution\CommercialGroup\Domain\CommercialGroup;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;

/**
 * Class ShowCommercialGroupQueryHandler
 * @package Distribution\CommercialGroup\Application\ShowCommercialGroup
 */
class ShowCommercialGroupQueryHandler
{
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    /**
     * @var LanguageRepository
     */
    private LanguageRepository $languageRepository;

    /**
     * @param CommercialGroupRepository $commercialGroupRepository
     */
    public function __construct(CommercialGroupRepository $commercialGroupRepository, LanguageRepository $languageRepository)
    {
        $this->commercialGroupRepository = $commercialGroupRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param ShowCommercialGroupQuery $query
     * @return ShowCommercialGroupResponse
     */
    public function handle(ShowCommercialGroupQuery $query): ShowCommercialGroupResponse
    {
        /**
         * @var LanguageCollection $languageCollection
         */
        $languageCollection = $this->languageRepository->getBy(new LanguageCriteria())->getCollection();

        /**
         * @var CommercialGroup $commercialGroup
         */
        $commercialGroup = $this->commercialGroupRepository->getById($query->getId());

        $translationsArray = [];
        /**
         * @var Translation $translation
         */
        foreach ($commercialGroup->getTranslations() as $translation) {
            try {
                $languageCode = null;
                /**
                 * @var Language $language
                 */
                $language = $languageCollection->getByProperty($translation->getLanguageId(), 'id');
                $languageCode = $language->getCode();
            } catch (Exception $e) {
            }

            $translationsArray[] = [
                'id' => $translation->getId(),
                'languageId' => $translation->getLanguageId(),
                'languageCode' => $languageCode,
                'translation' => $translation->getName(),
                'default' => $translation->isDefault(),
            ];
        }

        $commercialGroupArray = [
            'id' => $commercialGroup->getId(),
            'name' => $commercialGroup->getName(),
            'acrissName' => $commercialGroup->getAcrissName(),
            'status' => $commercialGroup->isActive(),
            'translationList' => $translationsArray,
        ];

        return new ShowCommercialGroupResponse($commercialGroupArray);
    }
}
