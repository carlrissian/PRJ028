<?php

declare(strict_types=1);

namespace Distribution\Branch\Infrastructure;

use Closure;
use Exception;
use Distribution\Branch\Domain\Branch;
use Shared\Repository\RepositoryHelper;
use Distribution\Branch\Domain\BranchCriteria;
use Distribution\Branch\Domain\BranchCollection;
use Distribution\Branch\Domain\BranchRepository;
use Distribution\Branch\Domain\BranchGetByResponse;

class BranchRepositorySap extends RepositoryHelper implements BranchRepository
{
    private const PREFIX_FUNCTION_NAME = 'BranchDb/BranchRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(BranchCriteria $branchCriteria): BranchGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new BranchCollection([]);

        try {
            $body = json_encode(parent::createCriteria($branchCriteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TBranchResponse', $collection, Closure::fromCallable([$this, 'arrayToBranch']));

            return new BranchGetByResponse($collection, $totalRows ?? 0);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @throws Exception
     */
    final public function getById(int $id): ?Branch
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response = $this->genericGetById('GET', $functionName, 'TBranchResponse');

            return $this->arrayToBranch($response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    final public function arrayToBranch(array $branchArray): Branch
    {
        return Branch::createFromArray($branchArray);
    }

    // FIXME se usa sólamente en StopSaleRepository
    final public function arrayListToArrayBranch(array $branchList): array
    {
        $branches = [];
        if (count($branchList) > 0) {
            for ($i = 0; $i < count($branchList); $i++) {
                $branches[] = $this->arrayToBranch($branchList[$i]);
            }
        }
        return $branches;
    }
}
