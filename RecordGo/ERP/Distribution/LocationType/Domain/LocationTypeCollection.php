<?php
declare(strict_types=1);


namespace Distribution\LocationType\Domain;


use Shared\Domain\Collection;

/**
 * Class LocationTypeCollection
 * @method LocationType[] getIterator()
 */
class LocationTypeCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return LocationType::class;
    }
}