<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Infrastructure;

use Faker\Factory;
use Faker\Generator;
use Distribution\Acriss\Domain\Acriss;
use Shared\Domain\Criteria\FilterOperator;
use Distribution\Acriss\Domain\AcrissCollection;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\CommercialGroup\Domain\CommercialGroup;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\CommercialGroup\Domain\CommercialGroupCollection;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;
use Distribution\CommercialGroup\Domain\CommercialGroupGetByResponse;

class CommercialGroupRepositoryFake implements CommercialGroupRepository
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function getBy(CommercialGroupCriteria $criteria): CommercialGroupGetByResponse
    {
        $objectArray = [];

        for ($i = 1; $i <= 15; $i++) {
            $objectArray[] = $this->generateCommercialGroup($i);
        }

        if ($criteria->hasFilters()) {
            foreach ($criteria->getFilters(['acrissId'], [FilterOperator::IN]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object CommercialGroup
                         */
                        $acrissCollection = $object->getAcriss();

                        $in_array = false;
                        foreach ($acrissCollection as $acriss) {
                            $in_array = in_array($acriss->getId(), $filter->getValue());
                            if ($in_array)
                                break;
                        }
                        return $in_array;
                    }
                );
            }
            foreach ($criteria->getFilters(['acrissId'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object CommercialGroup
                         */
                        $acrissCollection = $object->getAcriss();

                        foreach ($acrissCollection as $acriss) {
                            if ($acriss->getId() == $filter->getValue())
                                return true;
                        }
                        return false;
                    }
                );
            }
            foreach ($criteria->getFilters(['name'], [FilterOperator::EQUAL]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object CommercialGroup
                         */
                        return $object->getName() == $filter->getValue();
                    }
                );
            }
            foreach ($criteria->getFilters(['id'], [FilterOperator::IN]) as $filter) {
                $objectArray = array_filter(
                    $objectArray,
                    function ($object) use ($filter) {
                        /**
                         * @var $object CommercialGroup
                         */
                        return in_array($object->getId(), $filter->getValue());
                    }
                );
            }
        }

        $totalRows = count($objectArray);

        if ($criteria->hasPagination()) {
            $offset = $criteria->getPagination()->getOffset();
            $limit = $criteria->getPagination()->getLimit();
        } else {
            $offset = 0;
            $limit = $totalRows;
        }

        $objectArray = array_values($objectArray);

        $paginationArray = [];

        for ($i = 0; $i < $totalRows; $i++) {
            if ($i >= $offset && $i < $offset + $limit) {
                $paginationArray[] = $objectArray[$i];
            }
        }
        $collection = new CommercialGroupCollection($paginationArray);
        return new CommercialGroupGetByResponse($collection, $totalRows);
    }

    public function getById(int $id): ?CommercialGroup
    {
        return $this->generateCommercialGroup($id);
    }

    public function store(CommercialGroup $commercialGroup): int
    {
        return 0;
    }

    public function update(CommercialGroup $commercialGroup): int
    {
        return 0;
    }

    public function delete(int $id): bool
    {
        return true;
    }

    public function generateCommercialGroup($index = 1): CommercialGroup
    {
        $commercialGroupNames = ['Family', 'Compact', 'Luxury', 'Sport', 'Camper'];
        if ($this->faker->boolean) {
            $acrissCollection = new AcrissCollection([
                new Acriss($this->faker->numberBetween(1, 20), 'MBMR'),
                new Acriss($this->faker->numberBetween(1, 20), 'CBRV'),
            ]);
        } elseif ($this->faker->boolean) {
            $acrissCollection = new AcrissCollection([
                new Acriss($this->faker->numberBetween(1, 20), 'MBMV'),
            ]);
        } else {
            $acrissCollection = new AcrissCollection([
                new Acriss($this->faker->numberBetween(1, 20), 'MBMD'),
                new Acriss($this->faker->numberBetween(1, 20), 'MBMR'),
            ]);
        }
        return new CommercialGroup(
            $index,
            $commercialGroupNames[$this->faker->numberBetween(0, count($commercialGroupNames) - 1)] . $index,
            $acrissCollection,
            $this->faker->boolean,
            $this->faker->randomDigit,
            new DateTimeValueObject($this->faker->dateTime),
            $this->faker->randomDigit,
            new DateTimeValueObject($this->faker->dateTime)
        );
    }
}
