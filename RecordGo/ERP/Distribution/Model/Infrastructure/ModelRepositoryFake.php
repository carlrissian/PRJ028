<?php
declare(strict_types=1);

namespace Distribution\Model\Infrastructure;

use Distribution\Model\Domain\Model;
use Distribution\Model\Domain\ModelCollection;
use Distribution\Model\Domain\ModelCriteria;
use Distribution\Model\Domain\ModelGetByResponse;
use Distribution\Model\Domain\ModelRepository;

/**
 * Class ModelRepositoryFake
 * @package Distribution\Model\Infrastructure
 */
class ModelRepositoryFake implements ModelRepository
{
    /**
     * @var array[]
     */
    public array $modelList;
    /**
     * ModelRepositoryFake constructor.
     */
    public function __construct()
    {
        $this->modelList = [
            ['id' => 1, 'name' => 'A110', 'brandId' => 1],
            ['id' => 2, 'name' => '124 Spider', 'brandId' => 2],
            ['id' => 3, 'name' => 'Chiron', 'brandId' => 3],
            ['id' => 4, 'name' => 'Serie 1', 'brandId' => 4],
            ['id' => 5, 'name' => 'Dokker', 'brandId' => 5],
            ['id' => 6, 'name' => 'Fiesta', 'brandId' => 6],
            ['id' => 7, 'name' => 'Mustang', 'brandId' => 7],
            ['id' => 8, 'name' => 'Tucson', 'brandId' => 8],
            ['id' => 9, 'name' => 'CX-5', 'brandId' => 9],
            ['id' => 10, 'name' => '208', 'brandId' => 10]
        ];
    }

    /**
     * @param ModelCriteria $modelCriteria
     * @return ModelGetByResponse
     */
    public function getBy(ModelCriteria $modelCriteria): ModelGetByResponse
    {
        $models = [];
        foreach ($this->modelList as $model){
            $models[] = new Model($model['id'], $model['name'], $model['brandId']);
        }

        return new ModelGetByResponse(new ModelCollection($models), count($models));
    }

    final public function getIndex(int $id): ?int
    {
        $res = array_search($id, array_column($this->modelList,'id'));
        return ($res===false)?null:$res;
    }

    /**
     * @param int $id
     * @return Model|null
     */
    final public function getById(int $id): ?Model
    {
        $index = $this->getIndex($id);
        return ($index!==null)?new Model($this->modelList[$index]['id'], $this->modelList[$index]['name'], $this->modelList[$index]['brandId']):null;
    }
}
