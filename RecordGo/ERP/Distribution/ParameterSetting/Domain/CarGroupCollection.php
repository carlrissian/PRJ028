<?php
declare(strict_types=1);


namespace Distribution\ParameterSetting\Domain;


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