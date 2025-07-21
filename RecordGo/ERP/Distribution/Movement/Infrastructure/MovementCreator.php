<?php

namespace Distribution\Movement\Infrastructure;

use Shared\Domain\User;
use Shared\Utils\Utils;
use Distribution\Movement\Domain\State;
use Distribution\Movement\Domain\Branch;
use Distribution\Movement\Domain\Driver;
use Distribution\Movement\Domain\Location;
use Distribution\Movement\Domain\Movement;
use Distribution\Movement\Domain\Supplier;
use Distribution\Movement\Domain\Department;
use Distribution\Movement\Domain\VehicleLine;
use Distribution\Movement\Domain\BusinessUnit;
use Distribution\Movement\Domain\DeliveryNote;
use Distribution\Movement\Domain\MovementType;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\Movement\Domain\VehicleDelete;
use Distribution\Movement\Domain\VehicleFilter;
use Shared\Domain\ValueObject\FloatValueObject;
use Distribution\Movement\Domain\ManualLocation;
use Distribution\Movement\Domain\MovementStatus;
use Distribution\Movement\Domain\VehicleRecords;
use Distribution\Movement\Domain\TransportMethod;
use Distribution\Movement\Domain\Vehicle\Country;
use Distribution\Movement\Domain\Vehicle\Vehicle;
use Distribution\Movement\Domain\MovementCategory;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\Movement\Domain\BusinessUnitArticle;
use Distribution\Movement\Domain\VehicleFilter\Brand;
use Distribution\Movement\Domain\VehicleFilter\Model;
use Distribution\Movement\Domain\VehicleLineCollection;
use Distribution\Movement\Domain\DeliveryNoteCollection;
use Distribution\Movement\Domain\VehicleFilter\CarGroup;
use Distribution\Movement\Domain\VehicleFilterCollection;
use Distribution\Movement\Domain\VehicleFilter\SaleMethod;
use Distribution\Movement\Domain\AssignedLicensePlateUnits;
use Distribution\Movement\Domain\VehicleFilter\VehicleType;
use Distribution\Movement\Domain\VehicleFilter\VehicleStatus;
use Distribution\Movement\Domain\VehicleFilter\BrandCollection;
use Distribution\Movement\Domain\VehicleFilter\ModelCollection;
use Distribution\Movement\Domain\VehicleFilter\CarGroupCollection;
use Distribution\Movement\Domain\VehicleFilter\SaleMethodCollection;
use Distribution\Movement\Domain\VehicleFilter\VehicleTypeCollection;
use Distribution\Movement\Domain\VehicleFilter\VehicleStatusCollection;

class MovementCreator
{
    final static public function arrayToMovement(array $arrayMovement): Movement
    {
        // VEHICLE LINE
        $vehicleLineCollection = new VehicleLineCollection([]);

        if (isset($arrayMovement['VEHICLELINEARRAY']) && $arrayMovement['VEHICLELINEARRAY']) {
            foreach ($arrayMovement['VEHICLELINEARRAY'] as $vehicleLineArray) {

                $vehicleLineCollection->add(
                    new VehicleLine(
                        Vehicle::createFromArray($vehicleLineArray['VEHICLE']),
                        $vehicleLineArray['LOADDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['LOADDATE'])) : null,
                        $vehicleLineArray['UNLOADDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['UNLOADDATE'])) : null,
                        $vehicleLineArray['VEHICLERECORDS'] ?
                            new VehicleRecords(
                                $vehicleLineArray['VEHICLERECORDS']['VEHICLELOADKMS'],
                                FloatValueObject::create((float)$vehicleLineArray['VEHICLERECORDS']['VEHICLELOADBAT']),
                                $vehicleLineArray['VEHICLERECORDS']['VEHICLELOADTANK']
                            ) : null,
                        $vehicleLineArray['VEHICLERECORDS'] ?
                            new VehicleRecords(
                                $vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADKMS'] ?: null,
                                $vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADBAT'] ? FloatValueObject::create((float)$vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADBAT']) : null,
                                $vehicleLineArray['VEHICLERECORDS']['VEHICLEUNLOADTANK'] ?: null
                            ) : null,
                        $vehicleLineArray['WSOENDDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['WSOENDDATE'])) : null,
                        $vehicleLineArray['VEHICLEDELETE'] ?
                            new VehicleDelete(
                                $vehicleLineArray['VEHICLEDELETE']['CANCELLATIONUSER'] ?
                                    new User($vehicleLineArray['VEHICLEDELETE']['CANCELLATIONUSER']['TRANSPORTCANCELUSERID'], $vehicleLineArray['VEHICLEDELETE']['CANCELLATIONUSER']['USERALIAS']) : null,
                                $vehicleLineArray['VEHICLEDELETE']['CANCELDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleLineArray['VEHICLEDELETE']['CANCELDATE'])) : null
                            ) : null
                    )
                );
            }
        }

        // VEHICLE FILTER
        $vehicleFilterCollection = new VehicleFilterCollection([]);
        if (isset($arrayMovement['VEHICLEFILTERARRAY']) && $arrayMovement['VEHICLEFILTERARRAY']) {
            foreach ($arrayMovement['VEHICLEFILTERARRAY'] as $vehicleFilterArray) {

                $vehicleTypeCollection = new VehicleTypeCollection([]);
                foreach ($vehicleFilterArray['VEHICLETYPEARRAY'] as $vehicleTypeArray) {
                    $vehicleTypeCollection->add(
                        VehicleType::createFromArray($vehicleTypeArray)
                    );
                }

                $brandCollection = new BrandCollection([]);
                foreach ($vehicleFilterArray['BRANDARRAY'] as $brandArray) {
                    $brandCollection->add(
                        Brand::createFromArray($brandArray)
                    );
                }

                $modelCollection = new ModelCollection([]);
                foreach ($vehicleFilterArray['MODELARRAY'] as $modelArray) {
                    $modelCollection->add(
                        Model::createFromArray($modelArray)
                    );
                }

                $carGroupCollection = new CarGroupCollection([]);
                foreach ($vehicleFilterArray['CARGROUPARRAY'] as $carGroupArray) {
                    $carGroupCollection->add(
                        CarGroup::createFromArray($carGroupArray)
                    );
                }

                $saleMethodCollection = new SaleMethodCollection([]);
                foreach ($vehicleFilterArray['RESALECODEARRAY'] as $saleMethodArray) {
                    $saleMethodCollection->add(
                        SaleMethod::createFromArray($saleMethodArray)
                    );
                }

                $vehicleStatusCollection = new VehicleStatusCollection([]);
                foreach ($vehicleFilterArray['VEHICLESTATUSARRAY'] as $vehicleStatusArray) {
                    $vehicleStatusCollection->add(
                        VehicleStatus::createFromArray($vehicleStatusArray)
                    );
                }

                $vehicleFilterCollection->add(
                    new VehicleFilter(
                        $vehicleTypeCollection,
                        $brandCollection,
                        $modelCollection,
                        $carGroupCollection,
                        isset($vehicleFilterArray['VEHICLEKMFROM']) ? intval($vehicleFilterArray['VEHICLEKMFROM']) : null,
                        isset($vehicleFilterArray['VEHICLEKMTO']) ? intval($vehicleFilterArray['VEHICLEKMTO']) : null,
                        $vehicleFilterArray['RENTENDDATEFROM'] ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleFilterArray['RENTENDDATEFROM'])) : null,
                        $vehicleFilterArray['RENTENDDATETO'] ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleFilterArray['RENTENDDATETO'])) : null,
                        $saleMethodCollection,
                        $vehicleFilterArray['RAENDDATE'] ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleFilterArray['RAENDDATE'])) : null,
                        $vehicleStatusCollection,
                        isset($vehicleFilterArray['VEHICLECONNECTED']) ? boolval($vehicleFilterArray['VEHICLECONNECTED']) : null,
                    )
                );
            }
        }

        // DELIVERY NOTE
        $deliveryNoteCollection = new DeliveryNoteCollection([]);
        if (isset($arrayMovement['DELIVERYNOTEARRAY']) && $arrayMovement['DELIVERYNOTEARRAY']) {
            foreach ($arrayMovement['DELIVERYNOTEARRAY'] as $deliveryNoteArray) {
                $deliveryNoteCollection->add(
                    new DeliveryNote(
                        $deliveryNoteArray['ID'] ?? null,
                        $deliveryNoteArray['PUDODOCTYPEID'],
                        $deliveryNoteArray['PUDODOCTYPE'],
                        $deliveryNoteArray['PUDOPDF'],
                        $deliveryNoteArray['CREATIONDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($deliveryNoteArray['CREATIONDATE'])) : null,
                        $deliveryNoteArray['CREATIONUSERID'] ? new User($deliveryNoteArray['CREATIONUSERID']) : null
                    )
                );
            }
        }

        // Origin Location/Branch
        $originLocation = ($arrayMovement['ORIGINLOCATION'] && !$arrayMovement['ORIGINEXTERNALSUPPLIER']) ? Location::createFromArray($arrayMovement['ORIGINLOCATION']) : null;
        // Manual Origin Location/Branch
        $manualOriginLocation = $arrayMovement['MANUALORIGINLOCATION'] ?
            new ManualLocation(
                new Country(
                    intval($arrayMovement['MANUALORIGINLOCATION']['COUNTRY']['ORIGINEXTCOUNTRYID']),
                    $arrayMovement['MANUALORIGINLOCATION']['COUNTRY']['COUNTRYDESCRIPTION'],
                    $arrayMovement['MANUALORIGINLOCATION']['COUNTRY']['COUNTRYISO']
                ),
                new State(
                    intval($arrayMovement['MANUALORIGINLOCATION']['PROVINCE']['ORIGINEXTSTATEID']),
                    $arrayMovement['MANUALORIGINLOCATION']['PROVINCE']['STATENAME']
                ),
                $arrayMovement['MANUALORIGINLOCATION']['ORIGINEXTLOCATIONNOTE'] ?? ''
            ) : null;
        // External Origin Location/Supplier
        $externalOriginLocation = $arrayMovement['ORIGINLOCATION'] && $arrayMovement['ORIGINEXTERNALSUPPLIER'] ? Location::createFromArray($arrayMovement['ORIGINLOCATION']) : null;

        // Destination Location/Branch
        $destinationLocation = ($arrayMovement['DESTINATIONLOCATION']  && !$arrayMovement['DESTINATIONEXTERNALSUPPLIER']) ? Location::createFromArray($arrayMovement['DESTINATIONLOCATION']) : null;
        // Manual Destination Location/Branch
        $manualDestinationLocation = $arrayMovement['MANUALDESTINATIONLOCATION'] ?
            new ManualLocation(
                new Country(
                    intval($arrayMovement['MANUALDESTINATIONLOCATION']['COUNTRY']['DESTINYEXTCOUNTRYID']),
                    $arrayMovement['MANUALDESTINATIONLOCATION']['COUNTRY']['COUNTRYDESCRIPTION'],
                    $arrayMovement['MANUALDESTINATIONLOCATION']['COUNTRY']['COUNTRYISO']
                ),
                new State(
                    intval($arrayMovement['MANUALDESTINATIONLOCATION']['PROVINCE']['DESTINYEXTSTATEID']),
                    $arrayMovement['MANUALDESTINATIONLOCATION']['PROVINCE']['STATENAME']
                ),
                $arrayMovement['MANUALDESTINATIONLOCATION']['DESTINYEXTLOCATIONNOTE'] ?? ''
            ) : null;
        // External Destination Location/Supplier
        $externalDestinationlocation = $arrayMovement['DESTINATIONLOCATION'] && $arrayMovement['DESTINATIONEXTERNALSUPPLIER'] ? Location::createFromArray($arrayMovement['DESTINATIONLOCATION']) : null;


        return new Movement(
            intval($arrayMovement['ID']),
            $arrayMovement['SAPPO'] ?? null,
            $arrayMovement['MOVEMENTTYPE'] ? new MovementType($arrayMovement['MOVEMENTTYPE']['ID'], $arrayMovement['MOVEMENTTYPE']['TRANSPORTTYPE']) : null,
            $arrayMovement['MOVEMENTCATEGORY'] ? new MovementCategory($arrayMovement['MOVEMENTCATEGORY']['ID'], $arrayMovement['MOVEMENTCATEGORY']['TRANSCATNAME']) : null,
            $arrayMovement['EXTTRANSPORT'] == 1,
            $arrayMovement['MOVEMENTSTATUS'] ? new MovementStatus($arrayMovement['MOVEMENTSTATUS']['ID'], $arrayMovement['MOVEMENTSTATUS']['TRANSPORTSTATUS']) : null,
            $originLocation,
            $manualOriginLocation,
            $externalOriginLocation,
            $arrayMovement['ORIGINEXTERNALSUPPLIER'] ? Supplier::createFromArray($arrayMovement['ORIGINEXTERNALSUPPLIER']) : null,
            $arrayMovement['ORIGINBRANCH'] ?
                new Branch(
                    intval($arrayMovement['ORIGINBRANCH']['ID']),
                    $arrayMovement['ORIGINBRANCH']['BRANCHINTNAME'],
                    $arrayMovement['ORIGINBRANCH']['BRANCHIATA'] ?? null
                ) : null,
            $destinationLocation,
            $manualDestinationLocation,
            $externalDestinationlocation,
            $arrayMovement['DESTINATIONEXTERNALSUPPLIER'] ? Supplier::createFromArray($arrayMovement['DESTINATIONEXTERNALSUPPLIER']) : null,
            $arrayMovement['DESTINYBRANCH'] ?
                new Branch(
                    intval($arrayMovement['DESTINYBRANCH']['ID']),
                    $arrayMovement['DESTINYBRANCH']['BRANCHINTNAME'],
                    $arrayMovement['DESTINYBRANCH']['BRANCHIATA'] ?? null
                ) : null,
            $arrayMovement['ESTIMATEDDEPARTURE'] ? new DateValueObject(Utils::convertOdataDateToDateTime($arrayMovement['ESTIMATEDDEPARTURE'])) : null,
            null, // TODO ELIMINAR ESTE CAMPO, NO SE USA
            $arrayMovement['ESTIMATEDARRIVAL'] ? new DateValueObject(Utils::convertOdataDateToDateTime($arrayMovement['ESTIMATEDARRIVAL'])) : null,
            null, // TODO ELIMINAR ESTE CAMPO, NO SE USA
            $arrayMovement['DEPARTMENT'] ? Department::createFromArray($arrayMovement['DEPARTMENT']) : null,
            $arrayMovement['SUPPLIER'] ? Supplier::createFromArray($arrayMovement['SUPPLIER']) : null,
            $arrayMovement['DRIVER'] ? Driver::createFromArray($arrayMovement['DRIVER']) : null,
            $arrayMovement['BUSINESSUNIT'] ? BusinessUnit::createFromArray($arrayMovement['BUSINESSUNIT']) : null,
            $arrayMovement['BUSINESSUNITARTICLE'] ? BusinessUnitArticle::createFromArray($arrayMovement['BUSINESSUNITARTICLE']) : null,
            $arrayMovement['EXTTRANSPORTCOSTROUTE'] ? FloatValueObject::create($arrayMovement['EXTTRANSPORTCOSTROUTE']) : null,
            $arrayMovement['EXTTRANSPORTCOST'] ? FloatValueObject::create($arrayMovement['EXTTRANSPORTCOST']) : null,
            $arrayMovement['TRANSPORTUNITS'] ? intval($arrayMovement['TRANSPORTUNITS']) : null,
            $arrayMovement['TRANSPORTOBS'] ?? null,
            $vehicleLineCollection,
            $vehicleFilterCollection,
            $deliveryNoteCollection,
            $arrayMovement['ASSIGNEDLICENSEPLATEUNITS'] ?
                new AssignedLicensePlateUnits(
                    (int) $arrayMovement['ASSIGNEDLICENSEPLATEUNITS'][0]['TOTAL'],
                    (int) $arrayMovement['ASSIGNEDLICENSEPLATEUNITS'][0]['LOAD'],
                    (int) $arrayMovement['ASSIGNEDLICENSEPLATEUNITS'][0]['DOWNLOAD']
                ) : null,
            $arrayMovement['TRANSPORTMETHOD'] ?
                new TransportMethod(
                    $arrayMovement['TRANSPORTMETHOD']['ID'],
                    $arrayMovement['TRANSPORTMETHOD']['NAME']
                ) : null,
            // Datos creación
            $arrayMovement['CREATIONUSER'] ? new User($arrayMovement['CREATIONUSER']['ID'], $arrayMovement['CREATIONUSER']['USERALIAS']) : null,
            $arrayMovement['CREATIONDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($arrayMovement['CREATIONDATE'])) : null,
            // Datos edición
            $arrayMovement['EDITIONUSER'] ? new User($arrayMovement['EDITIONUSER']['ID'], $arrayMovement['EDITIONUSER']['USERALIAS']) : null,
            $arrayMovement['EDITIONDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($arrayMovement['EDITIONDATE'])) : null,
            // Datos cierre
            $arrayMovement['EDITIONUSER'] ? new User($arrayMovement['EDITIONUSER']['ID'], $arrayMovement['EDITIONUSER']['USERALIAS']) : null,
            $arrayMovement['EDITIONDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($arrayMovement['EDITIONDATE'])) : null,
            $arrayMovement['NOTES'], // Las notas de cierre se guardan en el mismo campo que las de cancelación
            // Datos cancelación
            $arrayMovement['EDITIONUSER'] ? new User($arrayMovement['EDITIONUSER']['ID'], $arrayMovement['EDITIONUSER']['USERALIAS']) : null,
            $arrayMovement['EDITIONDATE'] ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($arrayMovement['EDITIONDATE'])) : null,
            $arrayMovement['NOTES'] // Las notas de cancelación se guardan en el mismo campo que las de cierre
        );
    }
}
