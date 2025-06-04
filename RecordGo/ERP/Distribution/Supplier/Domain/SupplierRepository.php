<?php

declare(strict_types=1);

namespace Distribution\Supplier\Domain;

interface SupplierRepository
{
    /**
     * @param SupplierCriteria $criteria
     * @return SupplierGetByResponse
     */
    public function getBy(SupplierCriteria $criteria): SupplierGetByResponse;

    /**
     * @param int $id
     * @return Supplier|null
     */
    // public function getById(int $id): ?Supplier;

    /**
     * @param Supplier $supplier
     * @return Supplier|null
     */
    // public function store(Supplier $supplier): ?int;

    /**
     * @param Supplier $supplier
     * @return Supplier|null
     */
    // public function update(Supplier $supplier): ?int;
}
