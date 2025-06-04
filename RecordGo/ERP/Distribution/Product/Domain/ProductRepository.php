<?php

namespace Distribution\Product\Domain;

/**
 * Interface ProductRepository
 * @package Distribution\Product\Domain
 */
interface ProductRepository
{
    /**
     * @param ProductCriteria $criteria
     * @return ProductGetByResponse
     */
    public function getBy(ProductCriteria $criteria): ProductGetByResponse;

    /**
     * @param ProductById $productById
     * @return Product
     */
    // public function getById(ProductById $productById): Product;

    /**
     * @param int $versionId
     * @return Product
     */
    // public function getByVersionId(int $versionId): Product;

    /**
     * @param int $productId
     * @param HistoricalProductCriteria $criteria
     * @return ProductGetByResponse
     */
    // public function history(int $productId, HistoricalProductCriteria $criteria): ProductGetByResponse;

    /**
     * @param string $codeName
     * @param string $internalName
     * @param int|null $id
     * @return bool
     */
    // public function nameExists(string $codeName, string $internalName, ?int $id = null): bool;

    /**
     * @param Product $product
     * @return int
     */
    // public function store(Product $product): int;

    /**
     * @param Product $product
     * @return int
     */
    // public function update(Product $product): int;
}
