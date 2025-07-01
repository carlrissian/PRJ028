<?php
declare(strict_types=1);


namespace Distribution\ParameterSettingType\Domain;


use Shared\Domain\Collection;

class ParameterSettingTypeCollection extends Collection
{

    protected function type(): string
    {
        return ParameterSettingType::class;
    }
}