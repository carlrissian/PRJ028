<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

/**
 * Class ProductCollection
 * @method Product[] getIterator()
 */
final class ProductCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Product::class;
    }

    /**
     * @param array $productArray
     * @return self
     */
    public static function createFromArray(array $productArray): self
    {
        $collection = new self([]);
        foreach ($productArray as $product) {
            $collection->add(Product::createFromArray($product));
        }
        return $collection;
    }

    /**
     * @return array
     */
    public function toArraySAP(): array
    {
        $requestArray = [];
        foreach ($this->items as $item) {
            array_push($requestArray, $item->toArray());
        }
        return $requestArray;
    }
}
