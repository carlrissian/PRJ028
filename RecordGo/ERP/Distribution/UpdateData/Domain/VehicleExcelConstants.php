<?php

declare(strict_types=1);

namespace Distribution\UpdateData\Domain;

abstract class VehicleExcelConstants
{
    public const TITLE_LICENSE_PLATE = 'Matrícula';
    public const TITLE_VIN = 'Bastidor';
    public const TITLE_STATUS =  'Estado';
    public const TITLE_LOCATION = 'Localización';
    public const TITLE_RENTING_INIT_DATE = 'Fecha inicio de alquiler';
    public const TITLE_RENTING_END_DATE = 'Fecha fin de alquiler';
    public const TITLE_CHECK_IN_DATE = 'Fecha de devolución';
    public const TITLE_DATE_BLOCKAGE_START = 'Fecha inicio de bloqueo';
    public const TITLE_DATE_BLOCKAGE_END = 'Fecha fin de bloqueo';
    public const TITLE_BLOCKAGE_COMMENTS = 'Motivo del bloqueo';

    public const LICENSE_PLATE = 'LICENSEPLATE';
    public const VIN = 'VIN';
    public const STATUS =  'VEHICLESTATUS';
    public const LOCATION = 'LOCATION';
    public const RENTING_INIT_DATE = 'FIRSTRENTDATE';
    public const RENTING_END_DATE = 'RENTINGENDDATE';
    public const CHECK_IN_DATE = 'RETURNDATE';
    public const DATE_BLOCKAGE_START = 'INITBLOCKDATE';
    public const DATE_BLOCKAGE_END = 'ENDBLOCKDATE';
    public const BLOCKAGE_COMMENTS = 'MOTIVE';

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::TITLE_LICENSE_PLATE,
            self::TITLE_VIN,
            self::TITLE_STATUS,
            self::TITLE_LOCATION,
            self::TITLE_RENTING_INIT_DATE,
            self::TITLE_RENTING_END_DATE,
            self::TITLE_CHECK_IN_DATE,
            self::TITLE_DATE_BLOCKAGE_START,
            self::TITLE_DATE_BLOCKAGE_END,
            self::TITLE_BLOCKAGE_COMMENTS,
        ];
    }

    /**
     * @param string $title
     */
    public static function getHeader(string $title)
    {
        switch ($title) {
            case self::TITLE_LICENSE_PLATE:
                return self::LICENSE_PLATE;
            case self::TITLE_VIN:
                return self::VIN;
            case self::TITLE_STATUS:
                return self::STATUS;
            case self::TITLE_LOCATION:
                return self::LOCATION;
            case self::TITLE_RENTING_INIT_DATE:
                return self::RENTING_INIT_DATE;
            case self::TITLE_RENTING_END_DATE:
                return self::RENTING_END_DATE;
            case self::TITLE_CHECK_IN_DATE:
                return self::CHECK_IN_DATE;
            case self::TITLE_DATE_BLOCKAGE_START:
                return self::DATE_BLOCKAGE_START;
            case self::TITLE_DATE_BLOCKAGE_END:
                return self::DATE_BLOCKAGE_END;
            case self::TITLE_BLOCKAGE_COMMENTS:
                return self::BLOCKAGE_COMMENTS;
        }
    }

    /**
     * @param string $header
     */
    public static function getTitle(string $header)
    {
        switch ($header) {
            case self::LICENSE_PLATE:
                return self::TITLE_LICENSE_PLATE;
            case self::VIN:
                return self::TITLE_VIN;
            case self::STATUS:
                return self::TITLE_STATUS;
            case self::LOCATION:
                return self::TITLE_LOCATION;
            case self::RENTING_INIT_DATE:
                return self::TITLE_RENTING_INIT_DATE;
            case self::RENTING_END_DATE:
                return self::TITLE_RENTING_END_DATE;
            case self::CHECK_IN_DATE:
                return self::TITLE_CHECK_IN_DATE;
            case self::DATE_BLOCKAGE_START:
                return self::TITLE_DATE_BLOCKAGE_START;
            case self::DATE_BLOCKAGE_END:
                return self::TITLE_DATE_BLOCKAGE_END;
            case self::BLOCKAGE_COMMENTS:
                return self::TITLE_BLOCKAGE_COMMENTS;
        }
    }
}
