<?php
declare(strict_types=1);


namespace Distribution\Trim\Infrastructure;

use Distribution\Trim\Domain\Trim;
use Distribution\Trim\Domain\TrimCollection;
use Distribution\Trim\Domain\TrimCriteria;
use Distribution\Trim\Domain\TrimGetByResponse;
use Distribution\Trim\Domain\TrimRepository;
use Faker\Factory;
use Faker\Generator;

class TrimRepositoryFake implements TrimRepository
{
    public Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @inheritDoc
     */
    public function getBy(TrimCriteria $criteria): TrimGetByResponse
    {
        $finished = [];

        for ($i = 0; $i < 10; $i++) {
            $finished[] = new Trim($i + 1, $this->faker->company);
        }
        $collection = new TrimCollection($finished);
        return new TrimGetByResponse($collection, $collection->count());
    }

    public function getById(int $id): Trim
    {
        return new Trim(1, $this->faker->name);
    }

}