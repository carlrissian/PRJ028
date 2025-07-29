<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

final class BranchCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Branch::class;
    }

    /**
     * @param array $branchArray
     * @return self
     */
    public static function createFromArray(array $branchArray): self
    {
        $collection = new self([]);
        foreach ($branchArray as $branch) {
            $collection->add(Branch::createFromArray($branch));
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
