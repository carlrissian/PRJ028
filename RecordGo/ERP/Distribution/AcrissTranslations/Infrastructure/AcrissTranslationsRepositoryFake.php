<?php

declare(strict_types=1);

namespace Distribution\AcrissTranslations\Infrastructure;

use Faker\Factory;
use Faker\Generator;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\AcrissTranslations\Domain\AcrissTranslation;
use Distribution\AcrissTranslations\Domain\AcrissTranslationsCriteria;
use Distribution\AcrissTranslations\Domain\AcrissTranslationCollection;
use Distribution\AcrissTranslations\Domain\AcrissTranslationsRepository;
use Distribution\AcrissTranslations\Domain\AcrissTranslationsGetByResponse;

/**
 * Class AcrissRepositoryFake
 * @package Distribution\Acriss\Infrastructure
 */
class AcrissTranslationsRepositoryFake implements AcrissTranslationsRepository
{
    /**
     * @var Generator
     */
    private Generator $faker;

    /***
     * @var array
     */
    public array $acrissTranslationsList;

    /**
     * AcrissRepositoryFake constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->acrissTranslationsList = [];

        $this->acrissTranslationsList[] = [
            'acrissId' => 3,
            'branchId' => 1,
            'languageId' => 1,
            'languageCode' => 'ES',
            'translation' => 'Traduccion 1',
            'byDefault' => true
        ];
        $this->acrissTranslationsList[] = [
            'acrissId' => 3,
            'branchId' => 2,
            'languageId' => 1,
            'languageCode' => 'ES',
            'translation' => 'Traduccion 1',
            'byDefault' => true
        ];
        $this->acrissTranslationsList[] = [
            'acrissId' => 3,
            'branchId' => 2,
            'languageId' => 2,
            'languageCode' => 'PT',
            'translation' => 'Traduccion 2',
            'byDefault' => false
        ];
        $this->acrissTranslationsList[] = [
            'acrissId' => 3,
            'branchId' => 3,
            'languageId' => 1,
            'languageCode' => 'ES',
            'translation' => 'Traduccion 3',
            'byDefault' => false
        ];
        $this->acrissTranslationsList[] = [
            'acrissId' => 3,
            'branchId' => 3,
            'languageId' => 3,
            'languageCode' => 'GR',
            'translation' => 'Traduccion 4',
            'byDefault' => true
        ];
    }

    public function getBy(AcrissTranslationsCriteria $criteria): AcrissTranslationsGetByResponse
    {
        $objectArray = $this->acrissTranslationsList;

        if ($criteria->hasFilters()) {
            foreach ($criteria->getFilters(['acrissId'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object Translation
                         */
                        return $object['acrissId'] == $filter->getValue();
                    }
                );
            }
            foreach ($criteria->getFilters(['branchId'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object Translation
                         */
                        return $object['branchId'] == $filter->getValue();
                    }
                );
            }
            foreach ($criteria->getFilters(['languageId'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object Translation
                         */
                        return ['languageId'] == $filter->getValue();
                    }
                );
            }
        }

        $acrissTranslationsCollection = new AcrissTranslationCollection([]);
        foreach ($objectArray as $index => $translation) {
            $acrissTranslationsCollection->add(new AcrissTranslation(
                $index,
                $translation['acrissId'],
                $translation['branchId'],
                $translation['languageId'],
                $translation['languageCode'],
                $translation['translation'],
                $translation['byDefault']
            ));
        }
        return new AcrissTranslationsGetByResponse($acrissTranslationsCollection, $acrissTranslationsCollection->count());
    }

    /**
     * @param AcrissTranslation $translation
     * @return integer
     */
    public function store(AcrissTranslation $translation): int
    {
        return 1;
    }

    /**
     * @param AcrissTranslation $translation
     * @return integer
     */
    public function update(AcrissTranslation $translation): int
    {
        return 1;
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id): bool
    {
        return true;
    }
}
