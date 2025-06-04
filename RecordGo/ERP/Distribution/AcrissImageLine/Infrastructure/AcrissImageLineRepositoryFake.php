<?php

declare(strict_types=1);

namespace Distribution\AcrissImageLine\Infrastructure;

use Faker\Factory;
use Faker\Generator;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\AcrissImageLine\Domain\AcrissImageLine;
use Distribution\AcrissImageLine\Domain\AcrissImageLineCriteria;
use Distribution\AcrissImageLine\Domain\AcrissImageLineCollection;
use Distribution\AcrissImageLine\Domain\AcrissImageLineRepository;
use Distribution\AcrissImageLine\Domain\AcrissImageLineGetByResponse;

/**
 * Class ImageLineRepositoryFake
 * @package Distribution\AcrissImageLine\Infrastructure
 */
class AcrissImageLineRepositoryFake implements AcrissImageLineRepository
{
    /**
     * @var Generator
     */
    private Generator $faker;

    /**
     * @var array
     */
    public array $imageLinesList;

    /**
     * AcrissRepositoryFake constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();

        $this->imageLinesList = [];

        $this->imageLinesList[] = [
            'acrissId' => 3,
            'branchId' => 1,
            'index' => 1,
            'description' => 'Descripción 1',
            'url' => 'https://www.recordgoocasion.es/wp-content/uploads/2017/12/RecordGo-1-71-1-450x300.jpg'
        ];

        $this->imageLinesList[] = [
            'acrissId' => 3,
            'branchId' => 1,
            'index' => 2,
            'description' => 'Descripción 2',
            'url' => 'https://www.recordrentacar.com/blog/wp-content/uploads/2021/02/alquiler-coches-electricos-mallorca.jpg'
        ];
        $this->imageLinesList[] = [
            'acrissId' => 3,
            'branchId' => 2,
            'index' => 1,
            'description' => 'Descripción 3',
            'url' => 'https://www.recordrentacar.com/blog/wp-content/uploads/2021/02/alquiler-coches-electricos-mallorca.jpg'
        ];
        $this->imageLinesList[] = [
            'acrissId' => 3,
            'branchId' => 3,
            'index' => 1,
            'description' => 'Descripción 4',
            'url' => 'https://www.recordrentacar.com/blog/wp-content/uploads/2021/02/alquiler-coches-electricos-mallorca.jpg'
        ];
    }

    public function getBy(AcrissImageLineCriteria $criteria): AcrissImageLineGetByResponse
    {

        $objectArray = $this->imageLinesList;

        if ($criteria->hasFilters()) {
            foreach ($criteria->getFilters(['acrissId'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object ImageLine
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
                         * @var $object ImageLine
                         */
                        return $object['branchId'] == $filter->getValue();
                    }
                );
            }
        }
        $imageLineCollection = new AcrissImageLineCollection([]);
        foreach ($objectArray as $index => $imageLine) {
            $imageLineCollection->add(new AcrissImageLine($index, $imageLine['acrissId'], $imageLine['branchId'], $imageLine['index'], $imageLine['description'], $imageLine['url']));
        }
        return new AcrissImageLineGetByResponse($imageLineCollection, $imageLineCollection->count());
    }

    public function store(AcrissImageLine $imageLine): int
    {
        return 1;
    }

    public function update(AcrissImageLine $imageLine): int
    {
        return 1;
    }

    public function delete(int $id): bool
    {
        return true;
    }
}
