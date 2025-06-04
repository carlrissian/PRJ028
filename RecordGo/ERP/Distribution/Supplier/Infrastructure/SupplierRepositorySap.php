<?php

declare(strict_types=1);

namespace Distribution\Supplier\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Distribution\Supplier\Domain\Supplier;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Distribution\Supplier\Domain\SupplierCriteria;
use Distribution\Supplier\Domain\SupplierCollection;
use Distribution\Supplier\Domain\SupplierRepository;
use Distribution\Supplier\Domain\SupplierGetByResponse;

class SupplierRepositorySap extends RepositoryHelper implements SupplierRepository
{
    public const PREFIX_FUNCTION_NAME = 'Supplier/SupplierRepository';

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
    final public function getBy(SupplierCriteria $criteria): SupplierGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new SupplierCollection([]);

        try {
            $bodyArray = parent::createCriteria($criteria);
            $body = json_encode($bodyArray);

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TSupplierResponse', $collection, Closure::fromCallable([$this, 'arrayToSupplier']));

            return new SupplierGetByResponse($collection, $totalRows ?? 0);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getById(int $id): ?Supplier
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $supplierArray = $this->genericGetById('GET', $functionName, 'TSupplierResponse');

            return Supplier::createFromArray($supplierArray);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function store(Supplier $supplier): ?int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($supplier->toArray());

            $response = $this->genericSave('POST', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function update(Supplier $supplier): ?int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $supplier->getId();

        try {
            $body = json_encode($supplier->toArray());

            $response = $this->genericSave('PATCH', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    final private function arrayToSupplier(array $supplierArray): Supplier
    {
        return Supplier::createFromArray($supplierArray);
    }
}
