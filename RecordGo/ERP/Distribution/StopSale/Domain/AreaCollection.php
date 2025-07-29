<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

final class AreaCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Area::class;
    }

    /**
     * @param array $areaArray
     * @return self
     */
    public static function createFromArray(array $areaArray): self
    {
        $collection = new self([]);
        foreach ($areaArray as $area) {
            $collection->add(Area::createFromArray($area));
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
