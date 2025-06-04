<?php

declare(strict_types=1);

namespace Distribution\Department\Infrastructure;

use Closure;
use Exception;
use Shared\Domain\Criteria\Filter;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\FilterCollection;
use Distribution\Department\Domain\Department;
use Distribution\Department\Domain\DepartmentCriteria;
use Distribution\Department\Domain\DepartmentCollection;
use Distribution\Department\Domain\DepartmentRepository;
use Distribution\Department\Domain\DepartmentGetByResponse;

class DepartmentRepositorySap extends RepositoryHelper implements DepartmentRepository
{
    private const PREFIX_FUNCTION_NAME = 'Department/DepartmentRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(DepartmentCriteria $criteria): DepartmentGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new DepartmentCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TDepartmentResponse', $collection, Closure::fromCallable([$this, 'arrayToDepartment']));

            return (new DepartmentGetByResponse($collection, $totalRows ?? 0));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?Department
    {
        $getByResponse = $this->getBy(
            new DepartmentCriteria(
                new FilterCollection([
                    new Filter('ID', new FilterOperator(FilterOperator::EQUAL), $id)
                ])
            )
        );
        return ($getByResponse->getCollection()->count() > 0) ? $getByResponse->getCollection()->toArray()[0] : null;
    }


    final private function arrayToDepartment(array $departmentArray): Department
    {
        return Department::createFromArray($departmentArray);
    }
}
