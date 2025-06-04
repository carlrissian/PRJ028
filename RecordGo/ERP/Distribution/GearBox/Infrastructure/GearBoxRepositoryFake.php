<?php
declare(strict_types=1);


namespace Distribution\GearBox\Infrastructure;

use Distribution\Acriss\Domain\AcrissNameValueObject;
use Distribution\GearBox\Domain\GearBox;
use Distribution\GearBox\Domain\GearBoxCollection;
use Distribution\GearBox\Domain\GearBoxGetByResponse;
use Faker\Factory;
use Distribution\GearBox\Domain\GearBoxCriteria;
use Distribution\GearBox\Domain\GearBoxRepository;
use Faker\Generator;


class GearBoxRepositoryFake implements GearBoxRepository
{
    private Generator $faker;

    private array $acrissGearBox;

    public function __construct()
    {
        $this->faker = Factory::create();
        /*foreach (AcrissNameValueObject::$THIRD_ACRISS_LETTER_LIST as $key => $acrissLetter) {
            $this->acrissGearBox[] = [
                'id' => $key+1,
                'name' => AcrissNameValueObject::$THIRD_ACRISS_LETTER_NAMES[$key],
                'acrissLetter' => $acrissLetter,
            ];
        }*/
    }

    public function getBy(GearBoxCriteria $criteria): GearBoxGetByResponse
    {
        $gearBoxCollection = new GearBoxCollection([]);
        foreach ($this->acrissGearBox as $gearBox){
            $gearBoxCollection->add(new GearBox($gearBox['id'], $gearBox['name'], $gearBox['acrissLetter']));
        }
        return new GearBoxGetByResponse($gearBoxCollection, $gearBoxCollection->count());

    }

    public function getById(int $id): GearBox
    {
        return new GearBox($this->acrissGearBox[$id-1]['id'], $this->acrissGearBox[$id-1]['name'], $this->acrissGearBox[$id-1]['acrissLetter']);
    }

}
