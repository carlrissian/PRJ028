<?php

declare(strict_types=1);

namespace Distribution\SaleMethod\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Distribution\SaleMethod\Domain\SaleMethod;
use Distribution\SaleMethod\Domain\SaleMethodCriteria;
use Distribution\SaleMethod\Domain\SaleMethodCollection;
use Distribution\SaleMethod\Domain\SaleMethodRepository;
use Distribution\SaleMethod\Domain\SaleMethodGetByResponse;

class SaleMethodRepositorySap extends RepositoryHelper implements SaleMethodRepository
{
    private const PREFIX_FUNCTION_NAME = 'PurchaseMethod/PurchaseMethodRepository';

    /**
     * @inheritDoc
     */
    final public function getBy(SaleMethodCriteria $criteria): SaleMethodGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new SaleMethodCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TPurchaseMethodResponse', $collection, Closure::fromCallable([$this, 'arrayToSaleMethod']));

            return new SaleMethodGetByResponse($collection, $totalRows ?? 0);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $saleMethodArray
     * @return SaleMethod
     */
    private function arrayToSaleMethod(array $saleMethodArray): SaleMethod
    {
        return SaleMethod::createFromArray($saleMethodArray);
    }
}
