<?php

namespace Distribution\Movement\Infrastructure;

use Shared\Domain\User;
use Shared\Utils\Utils;
use Distribution\Movement\Domain\VehicleLine;
use Distribution\Movement\Domain\VehicleDelete;
use Shared\Domain\ValueObject\FloatValueObject;
use Distribution\Movement\Domain\VehicleRecords;
use Distribution\Movement\Domain\Vehicle\Vehicle;
use Shared\Domain\ValueObject\DateTimeValueObject;

class VehicleLineCreator
{
    final public static function arrayToVehicleLine(array $vehicleLineArray): VehicleLine
    {
        return new VehicleLine(
            Vehicle::createFromArray($vehicleLineArray['VEHICLE']),
            isset($vehicleLineArray['LOADDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['LOADDATE'])) : null,
            isset($vehicleLineArray['UNLOADDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['UNLOADDATE'])) : null,
            isset($vehicleLineArray['VEHICLERECORDS']) ?
                new VehicleRecords(
                    isset($vehicleLineArray['VEHICLERECORDS']['VEHICLELOADKMS']) ? intval($vehicleLineArray['VEHICLERECORDS']['VEHICLELOADKMS']) : null,
                    isset($vehicleLineArray['VEHICLERECORDS']['VEHICLELOADBAT']) ? FloatValueObject::create($vehicleLineArray['VEHICLERECORDS']['VEHICLELOADBAT']) : null,
                    isset($vehicleLineArray['VEHICLERECORDS']['VEHICLELOADTANK']) ? intval($vehicleLineArray['VEHICLERECORDS']['VEHICLELOADTANK']) : null
                ) : null,
            isset($vehicleLineArray['VEHICLERECORDS']) ?
                new VehicleRecords(
                    isset($vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADKMS']) ? intval($vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADKMS']) : null,
                    isset($vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADBAT']) ? FloatValueObject::create($vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADBAT']) : null,
                    isset($vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADTANK']) ? intval($vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADTANK']) : null
                ) : null,
            isset($vehicleLineArray['WSOENDDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['WSOENDDATE'])) : null,
            isset($vehicleLineArray['VEHICLEDELETE']) ?
                new VehicleDelete(
                    isset($vehicleLineArray['VEHICLEDELETE']['CANCELLATIONUSER']) ?
                        new User(
                            intval($vehicleLineArray['VEHICLEDELETE']['CANCELLATIONUSER']['TRANSPORTCANCELUSERID']),
                            $vehicleLineArray['VEHICLEDELETE']['CANCELLATIONUSER']['USERALIAS'] ?? null
                        ) : null,
                    isset($vehicleLineArray['VEHICLEDELETE']['CANCELDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['VEHICLEDELETE']['CANCELDATE'])) : null,
                ) : null
        );
    }
}
