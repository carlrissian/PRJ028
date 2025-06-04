<?php

declare(strict_types=1);

namespace Distribution\BusinessUnit\Infrastructure;

use Closure;
use Distribution\BusinessUnit\Domain\BusinessUnit;
use Distribution\BusinessUnit\Domain\BusinessUnitCollection;
use Distribution\BusinessUnit\Domain\BusinessUnitCriteria;
use Distribution\BusinessUnit\Domain\BusinessUnitGetByResponse;
use Distribution\BusinessUnit\Domain\BusinessUnitRepository;
use Exception;
use Shared\Repository\RepositoryHelper;
use Shared\Domain\RequestHelper\SapRequestHelper;

class BusinessUnitRepositorySap extends RepositoryHelper implements BusinessUnitRepository
{
    const PREFIX_FUNCTION_NAME = 'BusinessUnit/BusinessUnitRepository';

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(BusinessUnitCriteria $criteria): BusinessUnitGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new BusinessUnitCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TBusinessUnitResponse', $collection, Closure::fromCallable([$this, 'arrayToBusinessUnit']));

            return new BusinessUnitGetByResponse($collection, $totalRows);

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }



    final public function arrayToBusinessUnit(array $businessUnitArray): BusinessUnit
    {
        return BusinessUnit::createFromArray($businessUnitArray);
    }
}
