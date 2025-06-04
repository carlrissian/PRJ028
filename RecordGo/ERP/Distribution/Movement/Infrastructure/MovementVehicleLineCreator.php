<?php

namespace Distribution\Movement\Infrastructure;

use Shared\Domain\User;
use Shared\Utils\Utils;
use Distribution\Movement\Domain\Location;
use Distribution\Movement\Domain\Supplier;
use Distribution\Movement\Domain\BusinessUnit;
use Distribution\Movement\Domain\ManualLocation;
use Distribution\Movement\Domain\MovementStatus;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Movement\Domain\BusinessUnitArticle;
use Distribution\Movement\Domain\MovementVehicleLine;
use Distribution\Movement\Domain\VehicleLineCollection;

class MovementVehicleLineCreator
{
    final public static function arrayToMovementVehicleLine(array $vehicleLineArray): MovementVehicleLine
    {
        // VEHICLE LINE
        $vehicleLineCollection = new VehicleLineCollection([]);

        if (isset($vehicleLineArray['VEHICLELINE'])) {
            foreach ($vehicleLineArray['VEHICLELINE'] as $lineArray) {
                $vehicleLineCollection->add(VehicleLineCreator::arrayToVehicleLine($lineArray));
            }
        }

        return new MovementVehicleLine(
            intval($vehicleLineArray['ID']),
            $vehicleLineArray['SAPPO'] ?? null,
            isset($vehicleLineArray['BUSINESSUNIT']) ?
                new BusinessUnit(
                    $vehicleLineArray['BUSINESSUNIT']['ID'],
                    $vehicleLineArray['BUSINESSUNIT']['NAME'] ?? null,
                )
                : null,
            isset($vehicleLineArray['BUSINESSUNITARTICLE']) ?
                new BusinessUnitArticle(
                    $vehicleLineArray['BUSINESSUNITARTICLE']['ID'],
                    $vehicleLineArray['BUSINESSUNITARTICLE']['ITEMNAME'] ?? null
                )
                : null,
            isset($vehicleLineArray['SUPPLIER']) ?
                new Supplier(
                    intval($vehicleLineArray['SUPPLIER']['ID']),
                    $vehicleLineArray['SUPPLIER']['NAME'] ?? null
                )
                : null,
            $vehicleLineCollection,
            isset($vehicleLineArray['ORIGINLOCATION']) ?
                new Location(
                    $vehicleLineArray['ORIGINLOCATION']['ID'],
                    $vehicleLineArray['ORIGINLOCATION']['LOCATIONNAME'] ?? null
                )
                : null,
            isset($vehicleLineArray['MANUALORIGINLOCATION']) ? ManualLocation::createFromArray($vehicleLineArray['MANUALORIGINLOCATION'], ManualLocation::ORIGIN) : null,
            isset($vehicleLineArray['DESTINATIONLOCATION']) ?
                new Location(
                    $vehicleLineArray['DESTINATIONLOCATION']['ID'],
                    $vehicleLineArray['DESTINATIONLOCATION']['LOCATIONNAME'] ?? null
                )
                : null,
            isset($vehicleLineArray['MANUALDESTINATIONLOCATION']) ? ManualLocation::createFromArray($vehicleLineArray['MANUALDESTINATIONLOCATION'], ManualLocation::DESTINATION) : null,
            isset($vehicleLineArray['ESTIMATEDDEPARTURE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['ESTIMATEDDEPARTURE'])) : null,
            isset($vehicleLineArray['ESTIMATEDARRIVAL']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['ESTIMATEDARRIVAL'])) : null,
            isset($vehicleLineArray['MOVEMENTSTATUS']) ?
                new MovementStatus(
                    $vehicleLineArray['MOVEMENTSTATUS']['ID'],
                    $vehicleLineArray['MOVEMENTSTATUS']['TRANSPORTSTATUS'] ?? null
                ) : null,
            isset($vehicleLineArray['CreationUser']) ? User::createFromArray($vehicleLineArray['CreationUser']) : null,
            isset($vehicleLineArray['CREATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['CREATIONDATE'])) : null,
        );
    }
}
