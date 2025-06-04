<?php

declare(strict_types=1);

namespace Distribution\Model\Infrastructure;

use Exception;
use Distribution\Model\Domain\Model;
use Shared\Repository\RepositoryHelper;
use Distribution\Model\Domain\ModelCriteria;
use Distribution\Model\Domain\ModelCollection;
use Distribution\Model\Domain\ModelRepository;
use Distribution\Model\Domain\ModelGetByResponse;

class ModelRepositorySap extends RepositoryHelper implements ModelRepository
{
    private const PREFIX_FUNCTION_NAME = 'Model/ModelRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(ModelCriteria $criteria): ModelGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new ModelCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception("The getBy request hasn't returned a response");
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TModelResponse');

            foreach ($responseArray['TModelResponse'] as $itemArray) {
                $collection->add($this->arrayToModel($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new ModelGetByResponse($collection, $totalRows ?? 0);
    }

    public function getById(int $id): ?Model
    {
        // TODO: Implement getById() method.
    }


    final private function arrayToModel(array $modelArray): Model
    {
        return Model::createFromArray($modelArray);
    }
}
