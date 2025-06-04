<?php
declare(strict_types=1);


namespace Distribution\ParameterSetting\Application\FilterParameterSettings;


class FilterParameterSettingsResponse
{
    /**
     * @var array
     */
    private array $parameterSettingResponse;

    /**
     * FilterParameterSettingsResponse constructor.
     * @param array $parameterSettingResponse
     */
    public function __construct(array $parameterSettingResponse)
    {
        $this->parameterSettingResponse = $parameterSettingResponse;
    }

    /**
     * @return array
     */
    public function getParameterSettingResponse(): array
    {
        return $this->parameterSettingResponse;
    }

}