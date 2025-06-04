<?php
declare(strict_types=1);

namespace Distribution\ModelCode\Domain;

interface ModelCodeRepositoryInterface
{
    /**
     * @param ModelCodeCriteria $modelCodeCriteria
     * @return ModelCodeGetByResponse
     */
    public function getBy(ModelCodeCriteria $modelCodeCriteria): ModelCodeGetByResponse;

    /**
     * @param int $id
     * @return ModelCode
     */
    public function getById(int $id): ?ModelCode;
}