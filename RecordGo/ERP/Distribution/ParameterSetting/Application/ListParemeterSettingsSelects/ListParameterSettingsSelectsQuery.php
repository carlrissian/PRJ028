<?php
declare(strict_types=1);


namespace Distribution\ParameterSetting\Application\ListParemeterSettingsSelects;


class ListParameterSettingsSelectsQuery
{
    /**
     * @var int
     */
    private int $countryId;

    /**
     * @param int $countryId
     */
    public function __construct(int $countryId)
    {
        $this->countryId = $countryId;
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }


}