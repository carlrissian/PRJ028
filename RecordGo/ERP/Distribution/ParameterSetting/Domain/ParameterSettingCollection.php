<?php
declare(strict_types=1);


namespace Distribution\ParameterSetting\Domain;


use Shared\Domain\Collection;

class ParameterSettingCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return ParameterSetting::class;
    }
}