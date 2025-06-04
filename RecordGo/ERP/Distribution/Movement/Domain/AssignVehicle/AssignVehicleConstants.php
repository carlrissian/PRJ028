<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\AssignVehicle;

class AssignVehicleConstants
{
    public const TITLE_LICENSE_PLATE = 'Matrícula';
    public const TITLE_VIN = 'Bastidor';

    public const LICENSE_PLATE = 'LICENSEPLATE';
    public const VIN = 'VIN';

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::TITLE_LICENSE_PLATE,
            self::TITLE_VIN,
        ];
    }

    /**
     * @param string $header
     */
    public static function getHeader(string $header)
    {
        switch ($header) {
            case self::TITLE_LICENSE_PLATE:
                return self::LICENSE_PLATE;
            case self::TITLE_VIN:
                return self::VIN;
        }
    }
}
