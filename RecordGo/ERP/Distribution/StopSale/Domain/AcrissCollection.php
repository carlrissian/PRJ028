<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

final class AcrissCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Acriss::class;
    }

    /**
     * @param array $acrissArray
     * @return self
     */
    public static function createFromArray(array $acrissArray): self
    {
        $collection = new self([]);
        foreach ($acrissArray as $acriss) {
            $collection->add(Acriss::createFromArray($acriss));
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
