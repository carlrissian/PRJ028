<?php
declare(strict_types=1);


namespace Distribution\CarGroup\Domain;


use Shared\Domain\Collection;

class CarGroupCollection extends Collection
{

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return CarGroup::class;
    }
}