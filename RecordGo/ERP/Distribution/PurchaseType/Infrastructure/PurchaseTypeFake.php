<?php
declare(strict_types=1);


namespace Distribution\PurchaseType\Infrastructure;


use Distribution\PurchaseType\Domain\PurchaseType;
use Distribution\PurchaseType\Domain\PurchaseTypeCollection;
use Distribution\PurchaseType\Domain\PurchaseTypeCriteria;
use Distribution\PurchaseType\Domain\PurchaseTypeGetByResponse;
use Distribution\PurchaseType\Domain\PurchaseTypeRepository;
use Faker\Factory;
use Faker\Generator;

class PurchaseTypeFake implements PurchaseTypeRepository
{
    private Generator $faker;
    /**
     * @var array
     */
    public array $purchaseTypeList;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->purchaseTypeList = [
            ['id' => 1,  'name' => 'VN'],
            ['id' => 2,  'name' => 'VO'],
            ['id' => 3,  'name' => 'KM0'],

        ];

    }

    public function getBy(PurchaseTypeCriteria $purchaseTypeCriteria): PurchaseTypeGetByResponse
    {
        $objectArray = [];
        foreach ($this->purchaseTypeList as $purchaseType){
            $objectArray[] = new PurchaseType($purchaseType['id'], $purchaseType['name']);
        }

        $purchaseTypeCollection = new PurchaseTypeCollection($objectArray);

        return new PurchaseTypeGetByResponse($purchaseTypeCollection, $purchaseTypeCollection->count());
    }
    final public function getById(int $id, ?string $name=null): PurchaseType
    {
        if ($name===null){
            $name = $this->faker->randomElement($this->purchaseTypeList)['name'];
        }
        return new PurchaseType($id, $name);
    }
}
