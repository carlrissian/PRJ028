<?php

namespace Distribution\ParameterSettingType\Domain;

use Shared\Domain\Collection;

class ParameterSettingTypeCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return ParameterSettingType::class;
    }
}
