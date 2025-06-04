<?php

declare(strict_types=1);

namespace Distribution\SupplierContact\Infrastructure;

use Closure;
use Exception;
use Shared\Repository\RepositoryHelper;
use Distribution\SupplierContact\Domain\SupplierContact;
use Distribution\SupplierContact\Domain\SupplierContactCriteria;
use Distribution\SupplierContact\Domain\SupplierContactCollection;
use Distribution\SupplierContact\Domain\SupplierContactGetByResponse;
use Distribution\SupplierContact\Domain\SupplierContactRepositoryInterface;

class SupplierContactRepository extends RepositoryHelper implements SupplierContactRepositoryInterface
{
    public const PREFIX_FUNCTION_NAME = 'SupplierContact/SupplierContactRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(SupplierContactCriteria $contactCriteria): SupplierContactGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new SupplierContactCollection([]);

        try {
            $bodyArray = parent::createCriteria($contactCriteria);
            $body = json_encode($bodyArray);

            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TSupplierContactResponse', $collection, Closure::fromCallable([$this, 'arrayToSupplierContact']));

            return (new SupplierContactGetByResponse($collection, $totalRows ?? 0));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function store(SupplierContact $contact): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

        try {
            $body = json_encode($contact->toArray());

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
    final public function update(SupplierContact $contact): int
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $contact->getId();

        try {
            $body = json_encode($contact->toArray());

            $response = $this->genericSave('PATCH', $functionName, $body);

            return $response;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    final public function delete(int $id): bool
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

        try {
            $response = $this->sapRequestHelper->request('DELETE', $functionName, "");
            $responseArray = json_decode($response, true);

            return $responseArray['ID'] ? true : false;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    final public function arrayToSupplierContact(array $supplierContactArray): SupplierContact
    {
        return SupplierContact::createFromArray($supplierContactArray);
    }
}
