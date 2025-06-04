<?php
declare(strict_types=1);


namespace Distribution\BusinessUnitArticle\Infrastructure;

use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticle;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleCollection;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleCriteria;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleGetByResponse;
use Distribution\BusinessUnitArticle\Domain\BusinessUnitArticleRepository;
use Distribution\BusinessUnitArticle\Domain\MovementType;
use Distribution\BusinessUnitArticle\Domain\MovementTypeCollection;


class BusinessUnitArticleRepositoryFake implements BusinessUnitArticleRepository
{
    /**
     * @var array
     */
    public array $businessUnitArticleList;
    /**
     * @var array
     */
    private array $movementTypeList;


    public function __construct(){

        $this->businessUnitArticleList = [
            [ 'id' => 1, 'name' => 'TRANSPORTE BUYBACK', 'movementTypeId' => [1,2]],
            [ 'id' => 2, 'name' => 'TRANSPORTE VENTAB2B', 'movementTypeId' => [1,2]],
            [ 'id' => 3, 'name' => 'TRANSPORTE DISTRIBUCIÓN', 'movementTypeId' => [1,2]],
            [ 'id' => 4, 'name' => 'TRANSPORTE VENTA B2C', 'movementTypeId' => [1,2]],
            [ 'id' => 5, 'name' => 'MOVIMIENTO AEROPUERTO-ESTACIÓN', 'movementTypeId' => [1, 3]],
            [ 'id' => 6, 'name' => 'TRANSPORTE INFLEET', 'movementTypeId' => [2]],
        ];
        $this->movementTypeList = [
            [ 'id' => 1, 'name' => 'driver'],
            [ 'id' => 2, 'name' => 'carrier'],
            [ 'id' => 3, 'name' => 'operation']
        ];
    }

    public function getBy(BusinessUnitArticleCriteria $businessUnitArticleCriteria):BusinessUnitArticleGetByResponse
    {

        $businessUnitArticleCollection = new BusinessUnitArticleCollection([]);

        foreach ($this->businessUnitArticleList as $businessUnitArticle) {
            $movementTypeCollection = new MovementTypeCollection([]);
            foreach ($businessUnitArticle['movementTypeId'] as $movementTypeId){
                $movementTypeIndex = $movementTypeId-1;
                $movementTypeCollection->add(new MovementType($this->movementTypeList[$movementTypeIndex]['id'], $this->movementTypeList[$movementTypeIndex]['name']));
            }
            $businessUnitArticleCollection->add(new BusinessUnitArticle($businessUnitArticle['id'], $businessUnitArticle['name'], $movementTypeCollection));
        }

        return new BusinessUnitArticleGetByResponse($businessUnitArticleCollection, $businessUnitArticleCollection->count());
    }

    public function getIndex(int $id): int
    {
        return array_search($id, array_column($this->businessUnitArticleList,'id'));
    }
}