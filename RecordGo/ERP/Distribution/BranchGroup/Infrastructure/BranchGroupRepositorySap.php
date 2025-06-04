<?php

declare(strict_types=1);

namespace Distribution\BranchGroup\Infrastructure;

use Exception;
use Shared\Repository\RepositoryHelper;
use Distribution\BranchGroup\Domain\BranchGroup;
use Distribution\BranchGroup\Domain\BranchGroupCriteria;
use Distribution\BranchGroup\Domain\BranchGroupCollection;
use Distribution\BranchGroup\Domain\BranchGroupRepository;
use Distribution\BranchGroup\Domain\BranchGroupGetByResponse;

final class BranchGroupRepositorySap extends RepositoryHelper implements BranchGroupRepository
{
    private const PREFIX_FUNCTION_NAME = 'BranchGroup/BranchGroupRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(BranchGroupCriteria $criteria): BranchGroupGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new BranchGroupCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new Exception("The getBy request hasn't returned a response");
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TBranchGroupResponse');

            foreach ($responseArray['TBranchGroupResponse'] as $itemArray) {
                $collection->add($this->arrayToBranchGroup($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new BranchGroupGetByResponse($collection, $totalRows);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?BranchGroup
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response  = $this->sapRequestHelper->request('GET', $functionName, '');
            $responseArray = json_decode($response, true);

            return count($responseArray['TMovementResponse']) > 0 ? $this->arrayToBranchGroup($responseArray['TMovementResponse'][0]) : null;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    private function arrayToBranchGroup(array $branchGroupArray): BranchGroup
    {
        return BranchGroup::createFromArray($branchGroupArray);
    }
}
