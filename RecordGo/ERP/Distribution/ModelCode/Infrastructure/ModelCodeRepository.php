<?php
declare(strict_types=1);

namespace Distribution\ModelCode\Infrastructure;

use Distribution\ModelCode\Domain\ModelCode;
use Distribution\ModelCode\Domain\ModelCodeCollection;
use Distribution\ModelCode\Domain\ModelCodeCriteria;
use Distribution\ModelCode\Domain\ModelCodeGetByResponse;
use Distribution\ModelCode\Domain\ModelCodeRepositoryInterface;
use Faker\Factory;
use Faker\Generator;

class ModelCodeRepository implements ModelCodeRepositoryInterface
{

    //TODO: ELIMINAR SI NO SE USA

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @inheritDoc
     */
    final public function getBy(ModelCodeCriteria $modelCodeCriteria): ModelCodeGetByResponse
    {
        $ret = [];
        for ($i = 1; $i <= $modelCodeCriteria->getPagination()->getLimit(); $i++){
            $ret[] = $this->getById($i);
        }
        return new ModelCodeGetByResponse(new ModelCodeCollection($ret), $i);
    }

    /**
     * @inheritDoc
     */
    final public function getById(int $id): ?ModelCode
    {
        return new ModelCode($id, $this->faker->regexify('[A-Za-z0-9]{6}'));
    }
}