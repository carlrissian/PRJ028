<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Application\EditCommercialGroup;

use Exception;
use Distribution\Acriss\Domain\AcrissCriteria;
use Distribution\Language\Domain\LanguageCriteria;
use Distribution\Language\Domain\LanguageRepository;
use Distribution\Acriss\Domain\AcrissRepository;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;

class EditCommercialGroupQueryHandler
{
    /**
     * @var CommercialGroupRepository
     */
    private CommercialGroupRepository $commercialGroupRepository;

    /**
     * @var AcrissRepository
     */
    private AcrissRepository $acrissRepository;

    /**
     * @var LanguageRepository
     */
    private LanguageRepository $languageRepository;

    /**
     * EditCommercialGroupQueryHandler constructor.
     * 
     * @param CommercialGroupRepository $commercialGroupRepository
     * @param AcrissRepository $acrissRepository
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        CommercialGroupRepository $commercialGroupRepository,
        AcrissRepository $acrissRepository,
        LanguageRepository $languageRepository
    ) {
        $this->commercialGroupRepository = $commercialGroupRepository;
        $this->acrissRepository = $acrissRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param EditCommercialGroupQuery $query
     * @return EditCommercialGroupResponse
     */
    public function handle(EditCommercialGroupQuery $query): EditCommercialGroupResponse
    {
        /**
         * @var LanguageCollection $acrissCollection
         */
        $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria())->getCollection();

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
                $languageCode = $language->getLanguageCode();
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

        $acrissIds = [];
        foreach ($commercialGroup->getAcriss() as $acriss) {
            $acrissIds[] = $acriss->getId();
        }

        $commercialGroupArray = [
            'id' => $commercialGroup->getId(),
            'name' => $commercialGroup->getName(),
            'acrissIds' => $acrissIds,
            'status' => $commercialGroup->isActive(),
            'translations' => $translationsArray,
        ];

        $selectList = [
            'acrissList' => $this->generateAcrissList($acrissCollection),
            'languageList' => $this->generateLanguageList($languageCollection),
        ];

        $responseArray = [
            'commercialGroup' => $commercialGroupArray,
            'selectList' => $selectList
        ];

        return new EditCommercialGroupResponse($responseArray);
    }

    private function generateLanguageList($collection)
    {
        $result = [];

        foreach ($collection as $item) {
            $result[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'languageCode' => $item->getLanguageCode()
            ];
        }
        return $result;
    }

    private function generateAcrissList($collection)
    {

        $result = [];
        //se guarda las ids de acriss para no repetir campos
        foreach ($collection as $item) {

            $name = '';
            if ($item->getAcrissParentId() !== null) {
                continue;
            }
            $name = $item->getName();

            $result[] = [
                'id' => $item->getId(),
                'name' => $name
            ];
        }

        return $result;
    }
}
