<?php

declare(strict_types=1);

namespace Distribution\ParameterSetting\Application\DeleteParameterSetting;

class DeleteParameterSettingCommandResponse
{
    /**
     * @var bool
     */
    private bool $deleted;

    /**
     * DeleteParameterSettingCommandResponse constructor.
     *
     * @param bool $deleted
     */
    public function __construct(bool $deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * Indicates whether the deletion was successful.
     *
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }
}
