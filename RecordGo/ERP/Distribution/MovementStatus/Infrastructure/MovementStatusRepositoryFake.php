<?php
declare(strict_types=1);


namespace Distribution\MovementStatus\Infrastructure;


use Distribution\MovementStatus\Domain\MovementStatus;
use Distribution\MovementStatus\Domain\MovementStatusCollection;
use Distribution\MovementStatus\Domain\MovementStatusCriteria;
use Distribution\MovementStatus\Domain\MovementStatusGetByResponse;
use Distribution\MovementStatus\Domain\MovementStatusRepository;

class MovementStatusRepositoryFake implements MovementStatusRepository
{
    /***
     * @var array
     */
    public array $movementStatusList;

    public function __construct()
    {
        $this->movementStatusList = [
            ['id' => 1, 'name' => 'Pendiente'],
            ['id' => 2, 'name' => 'En curso'],
            ['id' => 3, 'name' => 'Finalizado'],
            ['id' => 4, 'name' => 'Anulado'],
        ];
    }
    public function getBy( MovementStatusCriteria $movementStatusCriteria):  MovementStatusGetByResponse{
        $objectArray = [];
        foreach ($this->movementStatusList as $movementStatus){
            $objectArray[] = new MovementStatus($movementStatus['id'], $movementStatus['name']);
        }

        $movementStatusCollection = new MovementStatusCollection($objectArray);

        return new MovementStatusGetByResponse($movementStatusCollection, $movementStatusCollection->count());
    }

    public function getIndex(int $id): int
    {
        return array_search($id, array_column($this->movementStatusList,'id'));
    }
}