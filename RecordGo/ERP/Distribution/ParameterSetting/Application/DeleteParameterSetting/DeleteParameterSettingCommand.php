<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\DeleteParameterSetting;

/**
 * Class DeleteParameterSettingCommand
 * @package Distribution\ParameterSetting\Application\DeleteParameterSetting
 */
class DeleteParameterSettingCommand
{
    /**
     * @var int
     */
    private int $id;

    /**
     * DeleteParameterSettingCommand constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Get the ID of the parameter setting to delete.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
