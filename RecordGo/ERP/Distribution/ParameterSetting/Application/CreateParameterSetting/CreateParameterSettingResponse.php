<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\CreateParameterSetting;

class CreateParameterSettingResponse
{
    /**
     * @var array
     */
    private $selectList;

    public function __construct(array $selectList)
    {
        $this->selectList = $selectList;
    }

    /**
     * @return  array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
