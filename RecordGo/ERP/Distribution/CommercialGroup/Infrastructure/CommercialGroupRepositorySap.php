<?php

declare(strict_types=1);

namespace Distribution\CommercialGroup\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\CommercialGroup\Domain\CommercialGroup;
use Distribution\CommercialGroup\Domain\CommercialGroupCriteria;
use Distribution\CommercialGroup\Domain\CommercialGroupCollection;
use Distribution\CommercialGroup\Domain\CommercialGroupRepository;
use Distribution\CommercialGroup\Domain\CommercialGroupGetByResponse;

class CommercialGroupRepositorySap extends RepositoryHelper implements CommercialGroupRepository
{
    private const PREFIX_FUNCTION_NAME = 'CommercialGroup/CommercialGroupRepository';

    /**
     * @param SapRequestHelper $sapRequestHelper
     */
    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(CommercialGroupCriteria $vehicleCriteria): CommercialGroupGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new CommercialGroupCollection([]);

        try {
            $body = json_encode(parent::createCriteria($vehicleCriteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TCommercialGroupResponse', $collection, Closure::fromCallable([$this, 'arrayToCommercialGroup']));

            return (new CommercialGroupGetByResponse($collection, $totalRows ?? 0));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?CommercialGroup
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $commercialGroupArray = $this->genericGetById('GET', $functionName, 'TCommercialGroupResponse');

            return $this->arrayToCommercialGroup($commercialGroupArray);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param CommercialGroup $commercialGroup
     * @return CommercialGroup
     */
    public function store(CommercialGroup $commercialGroup): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($commercialGroup->toArray());

            $response = $this->genericSave('POST', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param CommercialGroup $commercialGroup
     * @return CommercialGroup
     */
    public function update(CommercialGroup $commercialGroup): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $commercialGroup->getId();

        try {
            $body = json_encode($commercialGroup->toArray());

            $response = $this->genericSave('PATCH', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param int $id
     * @return CommercialGroup|null
     */
    public function delete(int $id): bool
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response = $this->sapRequestHelper->request('DELETE', $functionName, "");
            $responseArray = json_decode($response, true);

            return $responseArray['ID'] ? true : false;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @throws Exception
     */
    final public function arrayToCommercialGroup(array $commercialGroupArray): CommercialGroup
    {
        return CommercialGroup::createFromArray($commercialGroupArray);
    }
}
