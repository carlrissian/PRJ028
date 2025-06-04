<?php

namespace Distribution\Product\Infrastructure;

use Shared\Repository\RepositoryHelper;
use Distribution\Product\Domain\Product;
use Distribution\Product\Domain\ProductCriteria;
use Distribution\Product\Domain\ProductCollection;
use Distribution\Product\Domain\ProductRepository;
use Distribution\Product\Domain\ProductGetByResponse;

/**
 * Class ProductRepositoryFake
 * @package Distribution\Product\Infrastructure
 */
class ProductRepositorySap extends RepositoryHelper implements ProductRepository
{
    const PREFIX_FUNCTION_NAME = 'Product/ProductRepository';

    /**
     * @inheritDoc
     */
    public function getBy(ProductCriteria $criteria): ProductGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new ProductCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TProductListResponse');

            foreach ($responseArray['TProductListResponse'] as $itemArray) {
                $collection->add($this->arrayToProduct($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new ProductGetByResponse($collection, $totalRows ?? 0);
    }


    /**
     * @param array $productArray
     * @return Product
     */
    final public function arrayToProduct(array $productArray): Product
    {
        return Product::createFromArray($productArray);
    }
}
