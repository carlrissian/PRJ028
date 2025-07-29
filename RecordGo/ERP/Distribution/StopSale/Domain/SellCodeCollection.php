<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

final class SellCodeCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return SellCode::class;
    }

    /**
     * @param array $sellCodeArray
     * @return self
     */
    public static function createFromArray(array $sellCodeArray): self
    {
        $collection = new self([]);
        foreach ($sellCodeArray as $sellCode) {
            $collection->add(SellCode::createFromArray($sellCode));
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
