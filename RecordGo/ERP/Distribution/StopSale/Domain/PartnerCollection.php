<?php

namespace Distribution\StopSale\Domain;

use Shared\Domain\Collection;

final class PartnerCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Partner::class;
    }

    /**
     * @param array $partnerArray
     * @return self
     */
    public static function createFromArray(array $partnerArray): self
    {
        $collection = new self([]);
        foreach ($partnerArray as $partner) {
            $collection->add(Partner::createFromArray($partner));
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
