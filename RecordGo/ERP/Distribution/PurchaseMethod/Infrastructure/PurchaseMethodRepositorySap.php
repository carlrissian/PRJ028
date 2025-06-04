<?php

declare(strict_types=1);

namespace Distribution\PurchaseMethod\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Distribution\PurchaseMethod\Domain\PurchaseMethod;
use Distribution\PurchaseMethod\Domain\PurchaseMethodCriteria;
use Distribution\PurchaseMethod\Domain\PurchaseMethodCollection;
use Distribution\PurchaseMethod\Domain\PurchaseMethodRepository;
use Distribution\PurchaseMethod\Domain\PurchaseMethodGetByResponse;

class PurchaseMethodRepositorySap extends RepositoryHelper implements PurchaseMethodRepository
{
    private const PREFIX_FUNCTION_NAME = 'PurchaseMethod/PurchaseMethodRepository';

    /**
     * @inheritDoc
     */
    final public function getBy(PurchaseMethodCriteria $criteria): PurchaseMethodGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new PurchaseMethodCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TPurchaseMethodResponse', $collection, Closure::fromCallable([$this, 'arrayToPurchaseMethod']));

            return new PurchaseMethodGetByResponse($collection, $totalRows ?? 0);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @param array $purchaseMethodArray
     * @return PurchaseMethod
     */
    private function arrayToPurchaseMethod(array $purchaseMethodArray): PurchaseMethod
    {
        return PurchaseMethod::createFromArray($purchaseMethodArray);
    }
}
