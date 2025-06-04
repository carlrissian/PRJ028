<?php

declare(strict_types=1);

namespace Distribution\Route\Domain;

abstract class RouteExcelConstants
{
    public const TITLE_TRANSPORT_METHOD = 'Método de transporte (ID/Nombre)';
    public const TITLE_PROVIDERID = 'Código de proveedor (ID)';
    public const TITLE_ORIGIN_BRANCH = 'Delegación origen (ID/IATA)';
    public const TITLE_DESTINATION_BRANCH = 'Delegación destino (ID/IATA)';
    public const TITLE_AMOUNT_FULL_TRUCK = 'Importe carga completa';
    public const TITLE_AMOUNT_VEHICLE_1 = 'Importe por 1 vehículo';
    public const TITLE_AMOUNT_VEHICLE_2 = 'Importe por 2 vehículos';
    public const TITLE_AMOUNT_VEHICLE_3 = 'Importe por 3 vehículos';
    public const TITLE_AMOUNT_VEHICLE_4 = 'Importe por 4 vehículos';
    public const TITLE_AMOUNT_VEHICLE_5 = 'Importe por 5 vehículos';
    public const TITLE_AMOUNT_VEHICLE_6 = 'Importe por 6 vehículos';
    public const TITLE_AMOUNT_VEHICLE_7 = 'Importe por 7 vehículos';
    public const TITLE_AMOUNT_VEHICLE_8 = 'Importe por 8 vehículos';
    public const TITLE_AMOUNT_VEHICLE_9 = 'Importe por 9 vehículos';
    public const TITLE_AMOUNT_VEHICLE_10 = 'Importe por 10 vehículos';
    public const TITLE_AMOUNT_SUV = 'Importe por todoterreno';
    public const TITLE_AMOUNT_VAN = 'Importe por furgón';

    public const TRANSPORT_METHOD = 'TRANSPORTMETHOD';
    public const PROVIDERID = 'PROVIDERID';
    public const ORIGIN_BRANCH = 'ORIGINBRANCH';
    public const DESTINATION_BRANCH = 'DESTINATIONBRANCH';
    public const AMOUNT_FULL_TRUCK = 'COMPLETELOADAMOUNT';
    public const AMOUNT_VEHICLE_1 = 'VEHICLEAMOUNT1';
    public const AMOUNT_VEHICLE_2 = 'VEHICLEAMOUNT2';
    public const AMOUNT_VEHICLE_3 = 'VEHICLEAMOUNT3';
    public const AMOUNT_VEHICLE_4 = 'VEHICLEAMOUNT4';
    public const AMOUNT_VEHICLE_5 = 'VEHICLEAMOUNT5';
    public const AMOUNT_VEHICLE_6 = 'VEHICLEAMOUNT6';
    public const AMOUNT_VEHICLE_7 = 'VEHICLEAMOUNT7';
    public const AMOUNT_VEHICLE_8 = 'VEHICLEAMOUNT8';
    public const AMOUNT_VEHICLE_9 = 'VEHICLEAMOUNT9';
    public const AMOUNT_VEHICLE_10 = 'VEHICLEAMOUNT10';
    public const AMOUNT_SUV = 'SUVLOADAMOUNT';
    public const AMOUNT_VAN = 'VANLOADAMOUNT';

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::TITLE_TRANSPORT_METHOD,
            self::TITLE_PROVIDERID,
            self::TITLE_ORIGIN_BRANCH,
            self::TITLE_DESTINATION_BRANCH,
            self::TITLE_AMOUNT_FULL_TRUCK,
            self::TITLE_AMOUNT_VEHICLE_1,
            self::TITLE_AMOUNT_VEHICLE_2,
            self::TITLE_AMOUNT_VEHICLE_3,
            self::TITLE_AMOUNT_VEHICLE_4,
            self::TITLE_AMOUNT_VEHICLE_5,
            self::TITLE_AMOUNT_VEHICLE_6,
            self::TITLE_AMOUNT_VEHICLE_7,
            self::TITLE_AMOUNT_VEHICLE_8,
            self::TITLE_AMOUNT_VEHICLE_9,
            self::TITLE_AMOUNT_VEHICLE_10,
            self::TITLE_AMOUNT_SUV,
            self::TITLE_AMOUNT_VAN,
        ];
    }

    /**
     * @param string $header
     */
    public static function getHeader(string $header)
    {
        switch ($header) {
            case self::TITLE_TRANSPORT_METHOD:
                return self::TRANSPORT_METHOD;
            case self::TITLE_PROVIDERID:
                return self::PROVIDERID;
            case self::TITLE_ORIGIN_BRANCH:
                return self::ORIGIN_BRANCH;
            case self::TITLE_DESTINATION_BRANCH:
                return self::DESTINATION_BRANCH;
            case self::TITLE_AMOUNT_FULL_TRUCK:
                return self::AMOUNT_FULL_TRUCK;
            case self::TITLE_AMOUNT_VEHICLE_1:
                return self::AMOUNT_VEHICLE_1;
            case self::TITLE_AMOUNT_VEHICLE_2:
                return self::AMOUNT_VEHICLE_2;
            case self::TITLE_AMOUNT_VEHICLE_3:
                return self::AMOUNT_VEHICLE_3;
            case self::TITLE_AMOUNT_VEHICLE_4:
                return self::AMOUNT_VEHICLE_4;
            case self::TITLE_AMOUNT_VEHICLE_5:
                return self::AMOUNT_VEHICLE_5;
            case self::TITLE_AMOUNT_VEHICLE_6:
                return self::AMOUNT_VEHICLE_6;
            case self::TITLE_AMOUNT_VEHICLE_7:
                return self::AMOUNT_VEHICLE_7;
            case self::TITLE_AMOUNT_VEHICLE_8:
                return self::AMOUNT_VEHICLE_8;
            case self::TITLE_AMOUNT_VEHICLE_9:
                return self::AMOUNT_VEHICLE_9;
            case self::TITLE_AMOUNT_VEHICLE_10:
                return self::AMOUNT_VEHICLE_10;
            case self::TITLE_AMOUNT_SUV:
                return self::AMOUNT_SUV;
            case self::TITLE_AMOUNT_VAN:
                return self::AMOUNT_VAN;
        }
    }
}
