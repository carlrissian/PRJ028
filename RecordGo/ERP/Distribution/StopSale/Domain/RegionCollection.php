<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

/**
 * Class RegionCollection
 * @method Region[] getIterator()
 */
final class RegionCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Region::class;
    }

    /**
     * @param array $regionArray
     * @return self
     */
    public static function createFromArray(array $regionArray): self
    {
        $collection = new self([]);
        foreach ($regionArray as $region) {
            $collection->add(Region::createFromArray($region));
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
