<?php
declare(strict_types=1);


namespace Distribution\PurchaseMethod\Infrastructure;


use Distribution\PurchaseMethod\Domain\PurchaseMethod;
use Distribution\PurchaseMethod\Domain\PurchaseMethodCollection;
use Distribution\PurchaseMethod\Domain\PurchaseMethodCriteria;
use Distribution\PurchaseMethod\Domain\PurchaseMethodGetByResponse;
use Distribution\PurchaseMethod\Domain\PurchaseMethodRepository;
use Faker\Factory;
use Faker\Generator;

class PurchaseMethodRepositoryFake implements PurchaseMethodRepository
{
    private Generator $faker;
    /**
     * @var array
     */
    public array $purchaseMethodList;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->purchaseMethodList = [
            ['id' => 1,  'name' => 'BUYBACK'],
            ['id' => 2,  'name' => 'RENTING'],
            ['id' => 3,  'name' => 'RISK']
        ];
    }

    final public function getBy(PurchaseMethodCriteria $purchaseMethodCriteria): PurchaseMethodGetByResponse
    {
        $objectArray = [];
        foreach ($this->purchaseMethodList as $purchaseMethod){
            $objectArray[] = new PurchaseMethod($purchaseMethod['id'], $purchaseMethod['name']);
        }

        $purchaseMethodCollection = new PurchaseMethodCollection($objectArray);

        return new PurchaseMethodGetByResponse($purchaseMethodCollection, $purchaseMethodCollection->count());
    }

    final public function getById(int $id, ?string $name=null): PurchaseMethod
    {
        if ($name===null){
            $name = $this->faker->randomElement($this->purchaseMethodList)['name'];
        }
        return new PurchaseMethod($id, $name);
    }
}
