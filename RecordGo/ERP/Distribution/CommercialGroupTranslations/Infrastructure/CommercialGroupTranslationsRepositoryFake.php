<?php
declare(strict_types=1);

namespace Distribution\CommercialGroupTranslations\Infrastructure;

use Distribution\CommercialGroupTranslations\Domain\Translation;
use Distribution\CommercialGroupTranslations\Domain\TranslationCollection;
use Distribution\CommercialGroupTranslations\Domain\TranslationsGetByResponse;
use Distribution\CommercialGroupTranslations\Domain\CommercialGroupTranslationsRepository;
use Faker\Factory;
use Faker\Generator;


/**
 * Class CommercialGroupRepositoryFake
 * @package Distribution\CommercialGroup\Infrastructure
 */
class CommercialGroupTranslationsRepositoryFake implements CommercialGroupTranslationsRepository
{

    /**
     * @var Generator
     */
    private Generator $faker;
    /***
     * @var array
     */
    public array $commercialGroupTranslationsList;
    /**
     * CommercialGroupRepositoryFake constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->commercialGroupTranslationsList = [];

        $this->commercialGroupTranslationsList[] = [
            'commercialGroupId' => 3,
            'languageId' => 1,
            'languageCode' => 'ES',
            'translation' => 'Traduccion 1',
            'byDefault' => false
        ];
        $this->commercialGroupTranslationsList[] = [
            'commercialGroupId' => 3,
            'languageId' => 2,
            'languageCode' => 'PT',
            'translation' => 'Traduccion 2',
            'byDefault' => false
        ];
        $this->commercialGroupTranslationsList[] = [
            'commercialGroupId' => 3,
            'languageId' => 3,
            'languageCode' => 'GR',
            'translation' => 'Traduccion 3',
            'byDefault' => true
        ];
    }

    private function generateTranslations(int $id){
        $this->commercialGroupTranslationsList[] = [
            'commercialGroupId' => $id,
            'languageId' => $this->faker-> numberBetween(1,20),
            'languageCode' => $this->faker->languageCode,
            'translation' => $this->faker->name,
            'byDefault' => true
        ];
    }

    public function getByCommercialGroupId(int $id): TranslationsGetByResponse{

        if($id%2 == 0)
            $this->generateTranslations($id);

        $objectArray = $this->commercialGroupTranslationsList;

        $objectArray = array_filter(
            $objectArray,
            function ($object) use ($id) {
                /**
                 * @var $object Translation
                 */
                return $object['commercialGroupId'] == $id;
            }
        );


        $commercialGroupTranslationsCollection = new TranslationCollection([]);
        foreach ($objectArray as $index => $translation){
            $commercialGroupTranslationsCollection->add(new Translation($index, $translation['commercialGroupId'], $translation['languageId'], $translation['languageCode'], $translation['translation'], $translation['byDefault']));
        }
        return new TranslationsGetByResponse($commercialGroupTranslationsCollection, $commercialGroupTranslationsCollection->count());
    }


    public function store(Translation $translation): Translation
    {
        // TODO: Implement store() method.
        return new Translation($this->faker->randomDigitNotNull, $translation->getCommercialGroupId(), $translation->getLanguageId(), $translation->getLanguageCode(), $translation->getTranslation(), $translation->isByDefault());
    }

    public function update(Translation $translation): Translation
    {
        // TODO: Implement update() method.
        return $translation;
    }

    public function delete(int $id): Translation
    {
        return new Translation($id, 1,  1, 'ES', 'traduccion', false);
    }
}
