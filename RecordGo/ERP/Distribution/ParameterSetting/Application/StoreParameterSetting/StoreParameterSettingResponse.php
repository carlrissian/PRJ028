<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\StoreParameterSetting;

class StoreParameterSettingResponse
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * StoreParameterSettingResponse constructor.
     *
     * @param integer $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
