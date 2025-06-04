<?php
declare(strict_types=1);


namespace Distribution\ParameterSetting\Domain;


use Shared\Domain\Collection;

class AreaCollection extends Collection
{

    protected function type(): string
    {
        return Area::class;
    }
}