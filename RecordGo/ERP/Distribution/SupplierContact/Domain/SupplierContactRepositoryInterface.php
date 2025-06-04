<?php

declare(strict_types=1);

namespace Distribution\SupplierContact\Domain;

use Distribution\Shared\Domain\RepositoryException;

interface SupplierContactRepositoryInterface
{
    /**
     * @param SupplierContactCriteria $contactCriteria
     * @return SupplierContactGetByResponse
     */
    public function getBy(SupplierContactCriteria  $contactCriteria): SupplierContactGetByResponse;

    /**
     * @param SupplierContact $contact
     * @return int
     * @throws RepositoryException
     */
    public function store(SupplierContact $contact): int;

    /**
     * @param SupplierContact $contact
     * @return int
     * @throws RepositoryException
     */
    public function update(SupplierContact $contact): int;

    /**
     * @param int $id
     * @return bool
     * @throws RepositoryException
     */
    public function delete(int $id): bool;
}
