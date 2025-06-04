<?php
declare(strict_types=1);

namespace Distribution\CarClass\Infrastructure;

use Distribution\Acriss\Domain\AcrissNameValueObject;
use Distribution\CarClass\Domain\CarClass;
use Distribution\CarClass\Domain\CarClassCollection;
use Distribution\CarClass\Domain\CarClassCriteria;
use Distribution\CarClass\Domain\CarClassGetByResponse;
use Faker\Factory;
use Distribution\CarClass\Domain\CarClassRepository;
use Faker\Generator;


class CarClassRepositoryFake implements CarClassRepository
{
    private Generator $faker;
    /***
     * @var array
     */
    public array $carClassList;

    public function __construct()
    {
        $this->faker = Factory::create();

        foreach (AcrissNameValueObject::$FIRST_ACRISS_LETTER_LIST as $key => $acrissLetter) {
            $this->carClassList[] = [
                'id' => $key+1,
                'name' => AcrissNameValueObject::$FIRST_ACRISS_LETTER_NAMES[$key],
                'acrissLetter' => $acrissLetter,
            ];
        }

    }

    public function getBy(CarClassCriteria $carClassCriteria): CarClassGetByResponse
    {
        $objectArray = $this->carClassList;

        if($carClassCriteria->hasFilters()){
            //TODO IMPLEMENTAR FILTROS?

            foreach ($carClassCriteria->getFilters() as $filter){
                if($filter->getField() == 'id'){

                }
            }
        }

        $collection = new CarClassCollection([]);
        foreach ($objectArray as $carClass){
            $collection->add(new CarClass($carClass['id'], $carClass['name'], $carClass['acrissLetter']));
        }
        return new CarClassGetByResponse($collection, $collection->count());
    }

    public function getById(int $id): CarClass
    {
        return new CarClass($this->carClassList[$id-1]['id'],
            AcrissNameValueObject::$FIRST_ACRISS_LETTER_NAMES[$id-1],
            AcrissNameValueObject::$FIRST_ACRISS_LETTER_LIST[$id-1]

        );
    }


    public function getByAcrissLetter(string $acrissLetter): CarClass
    {
        return new CarClass(1,
            $this->faker->randomElement(AcrissNameValueObject::$FIRST_ACRISS_LETTER_LIST),
            $this->faker->randomElement(AcrissNameValueObject::$FIRST_ACRISS_LETTER_NAMES)
        );
    }

    /**
     * @param int $id
     * @param bool $carClassStatus
     * @return CarClass|null
     */
    public function activate(int $id, bool $carClassStatus): ?CarClass
    {
        return $this->createCarClass($id);
    }

    public function createCarClass(int $id): CarClass{
        return new CarClass(
            $id,
            $this->faker->randomElement(AcrissNameValueObject::$FIRST_ACRISS_LETTER_LIST),
            $this->faker->randomElement(AcrissNameValueObject::$FIRST_ACRISS_LETTER_NAMES)
        );
    }

}
