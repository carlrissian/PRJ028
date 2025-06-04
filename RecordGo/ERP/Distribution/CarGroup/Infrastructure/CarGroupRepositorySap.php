<?php

declare(strict_types=1);

namespace Distribution\CarGroup\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Utils\Utils;
use Distribution\CarGroup\Domain\CarGroup;
use Distribution\CarGroup\Domain\CarGroupCriteria;
use Distribution\CarGroup\Domain\CarGroupCollection;
use Distribution\CarGroup\Domain\CarGroupGetByResponse;
use Distribution\CarGroup\Domain\CarGroupRepository;

class CarGroupRepositorySap extends RepositoryHelper implements CarGroupRepository
{
    private const PREFIX_FUNCTION_NAME = 'CarGroup/CarGroupRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(CarGroupCriteria $groupCriteria): CarGroupGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $method = 'GET';
        $collection = new CarGroupCollection([]);
        try {
            $bodyArray = Utils::createCriteria($groupCriteria);

            $body = json_encode($bodyArray);
            $totalRows = $this->genericGetBy($method, $functionName, $body, 'TCarGroupResponse', $collection, Closure::fromCallable([$this, 'arrayToCarGroup']));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return new CarGroupGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?CarGroup
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;
        $method = 'GET';
        try {
            $response = $this->sapRequestHelper->request($method, $functionName, '');
            if ($response === false) {
                throw new Exception('Something fail during query');
            }
            $responseArray = json_decode($response, true);
            if (!$responseArray || !isset($responseArray['TCarGroupResponse'])) {
                throw new Exception('Something fail during getById');
            }
            $carGroupArray = $responseArray['TCarGroupResponse'][0];
            $carGroup = $this->arrayToCarGroup($carGroupArray);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return $carGroup;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function store(CarGroup $carGroup): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $method = 'POST';

        try {
            $settingArray = $carGroup->toArray();
            $body = json_encode($settingArray);
            $ret = $this->genericSave($method, $functionName, $body);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return $ret;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function update(CarGroup $carGroup): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $carGroup->getId();
        $method = 'PATCH';

        try {
            $settingArray = $carGroup->toArray();
            $body = json_encode($settingArray);
            $ret = $this->genericSave($method, $functionName, $body);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return $ret;
    }


    final private function arrayToCarGroup(array $carGroupArray): CarGroup
    {
        return CarGroup::createFromArray($carGroupArray);
    }
}
