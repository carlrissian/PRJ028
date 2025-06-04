<?php
declare(strict_types=1);


namespace Distribution\Language\Infrastructure;



use Distribution\Language\Domain\Language;
use Distribution\Language\Domain\LanguageCollection;
use Distribution\Language\Domain\LanguageCriteria;
use Distribution\Language\Domain\LanguageGetByResponse;
use Distribution\Language\Domain\LanguageRepository;
use Faker\Factory;
use Faker\Generator;


class LanguageRepositoryFake implements LanguageRepository
{
    //TODO: falta desarrollo de LanguageRepositorySap

    public Generator $faker;

    /**
     * @var array
     */
    public array $languageList;

    public function __construct()
    {
        $this->faker = Factory::create();

        $languageNames = ['Español', 'Portugues', 'Griego'];
        $languageCodes = ['ES', 'PT', 'GR'];
        $this->languageList = [];

        foreach ($languageCodes as $index => $code){
            $this->languageList[] = new Language($index+1, $languageNames[$index], $code);
        }
    }

    public function getBy(LanguageCriteria $languageCriteria): LanguageGetByResponse
    {
        $responseLanguageList = $this->languageList;

        $collection = new LanguageCollection($responseLanguageList);
        return new LanguageGetByResponse($collection, count($responseLanguageList));
    }

}