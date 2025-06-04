<?php
declare(strict_types=1);

namespace Distribution\Model\Domain;

/**
 * Interface ModelRepository
 * @package Distribution\Model\Domain
 */
interface ModelRepository
{
    /**
     * @param ModelCriteria $modelCriteria
     * @return ModelGetByResponse
     */
    public function getBy(ModelCriteria $modelCriteria): ModelGetByResponse;
    public function getById(int $id): ?Model;
}
