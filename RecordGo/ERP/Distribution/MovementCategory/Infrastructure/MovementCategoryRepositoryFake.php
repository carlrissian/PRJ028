<?php
declare(strict_types=1);


namespace Distribution\MovementCategory\Infrastructure;


use Distribution\MovementCategory\Domain\MovementCategory;
use Distribution\MovementCategory\Domain\MovementCategoryCollection;
use Distribution\MovementCategory\Domain\MovementCategoryCriteria;
use Distribution\MovementCategory\Domain\MovementCategoryGetByResponse;
use Distribution\MovementCategory\Domain\MovementCategoryRepository;

class MovementCategoryRepositoryFake implements  MovementCategoryRepository
{
    /***
     * @var array
     */
    public array $movementCategoryList;

    public function __construct()
    {
        $this->movementCategoryList = [
            ['id' => 1, 'name' => 'Ordinario'],
            ['id' => 2, 'name' => 'No ordinario'],
            ['id' => 3, 'name' => 'Interno'],
        ];
    }
    public function getBy( MovementCategoryCriteria $movementCategoryCriteria):  MovementCategoryGetByResponse
    {
        $objectArray = [];
        foreach ($this->movementCategoryList as $movementCategory){
            $objectArray[] = new MovementCategory($movementCategory['id'], $movementCategory['name']);
        }

        $movementCategoryCollection = new MovementCategoryCollection($objectArray);

        return new MovementCategoryGetByResponse($movementCategoryCollection, $movementCategoryCollection->count());
    }

    public function getIndex(int $id): int
    {
        return array_search($id, array_column($this->movementCategoryList,'id'));
    }
}