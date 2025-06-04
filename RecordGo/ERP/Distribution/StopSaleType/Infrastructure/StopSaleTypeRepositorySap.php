<?php

declare(strict_types=1);

namespace Distribution\StopSaleType\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Distribution\StopSaleType\Domain\StopSaleType;
use Distribution\StopSaleType\Domain\StopSaleTypeCriteria;
use Distribution\StopSaleType\Domain\StopSaleTypeCollection;
use Distribution\StopSaleType\Domain\StopSaleTypeGetByResponse;
use Distribution\StopSaleType\Domain\StopSaleTypeRepository;


class StopSaleTypeRepositorySap extends RepositoryHelper implements StopSaleTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'StopSellTypeList/StopSellTypeListRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(StopSaleTypeCriteria $criteria): StopSaleTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new StopSaleTypeCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));
            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TStopSellTypeListResponse', $collection, Closure::fromCallable([$this, 'arrayToStopSaleType']));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return new StopSaleTypeGetByResponse($collection, $totalRows ?? 0);
    }


    final private function arrayToStopSaleType(array $arrayType): StopSaleType
    {
        return new StopSaleType(
            intval($arrayType['ID']),
            $arrayType['NAME']
        );
    }
}
