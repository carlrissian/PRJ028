<?php

declare(strict_types=1);

namespace Distribution\AcrissBranchTranslations\Infrastructure;

use Faker\Factory;
use Faker\Generator;
use Distribution\AcrissBranchTranslations\Domain\Branch;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslation;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationCollection;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsCriteria;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsRepository;
use Distribution\AcrissBranchTranslations\Domain\AcrissBranchTranslationsGetByResponse;

/**
 * Class ImageLineRepositoryFake
 * @package Distribution\AcrissImageLine\Infrastructure
 */
class AcrissBranchTranslationsRepositoryFake implements AcrissBranchTranslationsRepository
{
    /**
     * @var Generator
     */
    private Generator $faker;

    /***
     * @var array
     */
    public array $branchTranslationsList;

    /**
     * AcrissRepositoryFake constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();

        $this->branchTranslationsList = [];

        $this->branchTranslationsList[] = [
            'acrissId' => 3,
            'branchId' => 1,
            'branchName' => 'Alicante',
            'branchIATA' => 'ALC',
            'commercialName' => 'Nombre comercial 3',
            'byDefault' => false
        ];
        $this->branchTranslationsList[] = [
            'acrissId' => 3,
            'branchId' => 2,
            'branchName' => 'Malaga',
            'branchIATA' => 'MAL',
            'commercialName' => 'Nombre comercial 1',
            'byDefault' => true
        ];
        $this->branchTranslationsList[] = [
            'acrissId' => 3,
            'branchId' => 3,
            'branchName' => 'Sevilla',
            'branchIATA' => 'SEV',
            'commercialName' => 'Nombre comercial 2',
            'byDefault' => false
        ];
    }

    public function getBy(AcrissBranchTranslationsCriteria $criteria): AcrissBranchTranslationsGetByResponse
    {
        // $objectArray = $this->branchTranslationsList;

        // $objectArray = array_filter(
        //     $objectArray,
        //     function ($object) use ($acrissId) {
        //         /**
        //          * @var $object AcrissBranchTranslation
        //          */
        //         return $object['acrissId'] == $acrissId;
        //     }
        // );

        // $branchTranslationsCollection = new AcrissBranchTranslationCollection([]);
        // foreach ($objectArray as $index => $branchTranslations) {
        //     $branchTranslationsCollection->add(new AcrissBranchTranslation(
        //         $index,
        //         new Branch(
        //             $branchTranslations['branchId'],
        //             $branchTranslations['branchName'],
        //             $branchTranslations['branchIATA']
        //         ),
        //         $branchTranslations['byDefault']
        //     ));
        // }
        // return new AcrissBranchTranslationsGetByResponse($branchTranslationsCollection, $branchTranslationsCollection->count());
        return new AcrissBranchTranslationsGetByResponse(new AcrissBranchTranslationCollection([]), 0);
    }

    public function store(AcrissBranchTranslation $branchTranslations): int
    {
        return 1;
    }

    public function update(AcrissBranchTranslation $branchTranslations): int
    {
        return 1;
    }

    public function delete(int $id): bool
    {
        return true;
    }
}
