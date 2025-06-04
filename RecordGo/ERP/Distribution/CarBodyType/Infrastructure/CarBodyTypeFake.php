<?php
declare(strict_types=1);


namespace Distribution\CarBodyType\Infrastructure;



use Distribution\CarBodyType\Domain\CarBodyType;
use Distribution\CarBodyType\Domain\CarBodyTypeCriteria;
use Distribution\CarBodyType\Domain\CarBodyTypeGetByResponse;
use Distribution\CarBodyType\Domain\CarBodyTypeRepository;
use Faker\Factory;
use Faker\Generator;
use Shared\Domain\TableResponse;

/**
 * Class CarBodyTypeFake
 * @package Distribution\CarBodyType\Infrastructure
 */
class CarBodyTypeFake implements CarBodyTypeRepository
{
    /**
     * @var Generator
     */
    private Generator $faker;

    /**
     * CarBodyTypeFake constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @param CarBodyTypeCriteria $bodyworkCriteria
     * @return CarBodyTypeGetByResponse
     */
    public function getBy(CarBodyTypeCriteria $bodyworkCriteria): CarBodyTypeGetByResponse
    {
        $bodywork = [];

        for ($i = 0; $i < 10; $i++) {
            $bodywork[] = new CarBodyType($i + 1, $this->faker->company);
        }
        return new CarBodyTypeGetByResponse($bodywork, count($bodywork));
    }
}