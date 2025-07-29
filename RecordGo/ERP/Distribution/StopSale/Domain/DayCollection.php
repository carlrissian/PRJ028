<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

final class DayCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Day::class;
    }

    /**
     * @param array $dayArray
     * @return self
     */
    public static function createFromArray(array $dayArray): self
    {
        $collection = new self([]);
        foreach ($dayArray as $day) {
            $collection->add(Day::createFromArray($day));
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
