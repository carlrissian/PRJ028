<?php
declare(strict_types=1);


namespace Distribution\Movement\Domain\VehicleFilter;


use Shared\Domain\Collection;

class BrandCollection extends Collection
{

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Brand::class;
    }
}