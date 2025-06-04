<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Utils\Utils;
use Distribution\Movement\Domain\Vehicle\Vehicle;
use Shared\Domain\ValueObject\DateTimeValueObject;

class VehicleLine
{
    /**
     * @var Vehicle
     */
    private Vehicle $vehicle;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $actualLoadDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $actualUnloadDate;

    /**
     * @var VehicleRecords|null
     * Specific vehicle parameters saved at the moment of movement creation
     */
    private ?VehicleRecords $vehicleRecordsLoad;

    /**
     * @var VehicleRecords|null
     *  Specific vehicle parameters saved at the moment of movement closing
     */
    private ?VehicleRecords $vehicleRecordsUnload;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $vehicleMaintenanceEndDate;

    /**
     * @var VehicleDelete|null
     */
    private ?VehicleDelete $vehicleDelete;

    /**
     * VehicleLine constructor.
     * 
     * @param Vehicle $vehicle
     * @param DateTimeValueObject|null $actualLoadDate
     * @param DateTimeValueObject|null $actualUnloadDate
     * @param VehicleRecords|null $vehicleRecordsLoad
     * @param VehicleRecords|null $vehicleRecordsUnload
     * @param DateTimeValueObject|null $vehicleMaintenanceEndDate
     * @param VehicleDelete|null $vehicleDelete
     */
    public function __construct(
        Vehicle $vehicle,
        ?DateTimeValueObject $actualLoadDate = null,
        ?DateTimeValueObject $actualUnloadDate = null,
        ?VehicleRecords $vehicleRecordsLoad = null,
        ?VehicleRecords $vehicleRecordsUnload = null,
        ?DateTimeValueObject $vehicleMaintenanceEndDate = null,
        ?VehicleDelete $vehicleDelete = null
    ) {
        $this->vehicle = $vehicle;
        $this->actualLoadDate = $actualLoadDate;
        $this->actualUnloadDate = $actualUnloadDate;
        $this->vehicleRecordsLoad = $vehicleRecordsLoad;
        $this->vehicleRecordsUnload = $vehicleRecordsUnload;
        $this->vehicleMaintenanceEndDate = $vehicleMaintenanceEndDate; // Esto no tiene sentido que este en la linea del movimiento.
        $this->vehicleDelete = $vehicleDelete;
    }

    /**
     * @return Vehicle
     */
    final public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getActualLoadDate(): ?DateTimeValueObject
    {
        return $this->actualLoadDate;
    }

    /**
     * @param DateTimeValueObject|null $actualLoadDate
     */
    public function setActualLoadDate($actualLoadDate)
    {
        $this->actualLoadDate = $actualLoadDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getActualUnloadDate(): ?DateTimeValueObject
    {
        return $this->actualUnloadDate;
    }

    /**
     * @param DateTimeValueObject|null $actualUnloadDate
     */
    public function setActualUnloadDate($actualUnloadDate)
    {
        $this->actualUnloadDate = $actualUnloadDate;
    }

    /**
     * @return VehicleRecords|null
     */
    final public function getVehicleRecordsLoad(): ?VehicleRecords
    {
        return $this->vehicleRecordsLoad;
    }

    /**
     * @return VehicleRecords|null
     */
    final public function getVehicleRecordsUnload(): ?VehicleRecords
    {
        return $this->vehicleRecordsUnload;
    }

    /**
     * @param VehicleRecords|null $vehicleRecordsUnload
     */
    public function setVehicleRecordsUnload($vehicleRecordsUnload)
    {
        $this->vehicleRecordsUnload = $vehicleRecordsUnload;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getVehicleMaintenanceEndDate(): ?DateTimeValueObject
    {
        return $this->vehicleMaintenanceEndDate;
    }


    /**
     * @return VehicleDelete|null
     */
    final public function getVehicleDelete(): ?VehicleDelete
    {
        return $this->vehicleDelete;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'VEHICLEID' => $this->getVehicle()->getId(),
            'VEHICLELOADKMS' => $this->getVehicleRecordsLoad() ? $this->getVehicleRecordsLoad()->getKilometersActual() : null,
            'VEHICLELOADBAT' => $this->getVehicleRecordsLoad() && $this->getVehicleRecordsLoad()->getBatteryActual() ? $this->getVehicleRecordsLoad()->getBatteryActual()->getFloatValue(2) : $this->getVehicle()->getBatteryCapacity(),
            'VEHICLELOADTANK' => $this->getVehicleRecordsLoad() ? $this->getVehicleRecordsLoad()->getTankActualOctaves() : $this->getVehicle()->getTankCapacity(),
            'VEHICLEUNLOADKMS' => $this->getVehicleRecordsUnload() ? $this->getVehicleRecordsUnload()->getKilometersActual() : null,
            'VEHICLEUNLOADBAT' => $this->getVehicleRecordsUnload() && $this->getVehicleRecordsUnload()->getBatteryActual() ? $this->getVehicleRecordsUnload()->getBatteryActual()->getFloatValue(2) : null,
            'VEHICLEUNLOADTANK' => $this->getVehicleRecordsUnload() && $this->getVehicleRecordsUnload()->getTankActualOctaves() ? $this->getVehicleRecordsUnload()->getTankActualOctaves() : null,
            'LOADDATE' => ($this->getActualLoadDate()) ? Utils::formatStringDateTimeToOdataDate($this->getActualLoadDate()->__toString(), 'd/m/Y H:i:s') : null,
            'UNLOADDATE' => ($this->getActualUnloadDate()) ? Utils::formatStringDateTimeToOdataDate($this->getActualUnloadDate()->__toString(), 'd/m/Y H:i:s') : null,
            'VEHICLESTATUSID' => ($this->getVehicle()->getStatus()) ? $this->getVehicle()->getStatus()->getId() : null,
        ];
    }
}
