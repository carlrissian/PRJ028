<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\Movement\Domain\VehicleFilter\Brand;
use Distribution\Movement\Domain\VehicleFilter\Model;
use Distribution\Movement\Domain\VehicleFilter\CarGroup;
use Distribution\Movement\Domain\VehicleFilter\SaleMethod;
use Distribution\Movement\Domain\VehicleFilter\VehicleType;
use Distribution\Movement\Domain\VehicleFilter\VehicleStatus;
use Distribution\Movement\Domain\VehicleFilter\BrandCollection;
use Distribution\Movement\Domain\VehicleFilter\ModelCollection;
use Distribution\Movement\Domain\VehicleFilter\CarGroupCollection;
use Distribution\Movement\Domain\VehicleFilter\SaleMethodCollection;
use Distribution\Movement\Domain\VehicleFilter\VehicleTypeCollection;
use Distribution\Movement\Domain\VehicleFilter\VehicleStatusCollection;

class VehicleFilter
{
    /**
     * @var VehicleTypeCollection|null
     */
    private ?VehicleTypeCollection $vehicleTypeCollection;

    /**
     * @var BrandCollection|null
     */
    private ?BrandCollection $brandCollection;

    /**
     * @var ModelCollection|null
     */
    private ?ModelCollection $modelCollection;

    /**
     * @var CarGroupCollection|null
     */
    private ?CarGroupCollection $carGroupCollection;

    /**
     * @var int|null
     */
    private ?int $kilometersFrom;

    /**
     * @var int|null
     */
    private ?int $kilometersTo;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $rentingEndDateFrom;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $rentingEndDateTo;

    /**
     * @var SaleMethodCollection|null
     */
    private ?SaleMethodCollection $saleMethodCollection;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $checkInDateFrom;

    /**
     * @var VehicleStatusCollection|null
     */
    private ?VehicleStatusCollection $vehicleStatusCollection;

    /**
     * @var bool|null
     */
    private ?bool $connectedVehicle;

    /**
     * VehicleFilter constructor.
     * 
     * @param VehicleTypeCollection|null $vehicleTypeCollection
     * @param BrandCollection|null $brandCollection
     * @param ModelCollection|null $modelCollection
     * @param CarGroupCollection|null $carGroupCollection
     * @param int|null $kilometersFrom
     * @param int|null $kilometersTo
     * @param DateValueObject|null $rentingEndDateFrom
     * @param DateValueObject|null $rentingEndDateTo
     * @param SaleMethodCollection|null $saleMethodCollection
     * @param DateValueObject|null $checkInDateFrom
     * @param VehicleStatusCollection|null $vehicleStatusCollection
     * @param bool|null $connectedVehicle
     */
    public function __construct(
        ?VehicleTypeCollection $vehicleTypeCollection,
        ?BrandCollection $brandCollection,
        ?ModelCollection $modelCollection,
        ?CarGroupCollection $carGroupCollection,
        ?int $kilometersFrom,
        ?int $kilometersTo,
        ?DateValueObject $rentingEndDateFrom,
        ?DateValueObject $rentingEndDateTo,
        ?SaleMethodCollection $saleMethodCollection,
        ?DateValueObject $checkInDateFrom,
        ?VehicleStatusCollection $vehicleStatusCollection,
        ?bool $connectedVehicle
    ) {
        $this->vehicleTypeCollection = $vehicleTypeCollection;
        $this->brandCollection = $brandCollection;
        $this->modelCollection = $modelCollection;
        $this->carGroupCollection = $carGroupCollection;
        $this->kilometersFrom = $kilometersFrom;
        $this->kilometersTo = $kilometersTo;
        $this->rentingEndDateFrom = $rentingEndDateFrom;
        $this->rentingEndDateTo = $rentingEndDateTo;
        $this->saleMethodCollection = $saleMethodCollection;
        $this->checkInDateFrom = $checkInDateFrom;
        $this->vehicleStatusCollection = $vehicleStatusCollection;
        $this->connectedVehicle = $connectedVehicle;
    }

    /**
     * @return VehicleTypeCollection|null
     */
    public function getVehicleTypeCollection(): ?VehicleTypeCollection
    {
        return $this->vehicleTypeCollection;
    }

    /**
     * @return BrandCollection|null
     */
    public function getBrandCollection(): ?BrandCollection
    {
        return $this->brandCollection;
    }

    /**
     * @return ModelCollection|null
     */
    public function getModelCollection(): ?ModelCollection
    {
        return $this->modelCollection;
    }

    /**
     * @return CarGroupCollection|null
     */
    public function getCarGroupCollection(): ?CarGroupCollection
    {
        return $this->carGroupCollection;
    }

    /**
     * @return int|null
     */
    public function getKilometersFrom(): ?int
    {
        return $this->kilometersFrom;
    }

    /**
     * @return int|null
     */
    public function getKilometersTo(): ?int
    {
        return $this->kilometersTo;
    }

    /**
     * @return DateValueObject|null
     */
    public function getRentingEndDateFrom(): ?DateValueObject
    {
        return $this->rentingEndDateFrom;
    }

    /**
     * @return DateValueObject|null
     */
    public function getRentingEndDateTo(): ?DateValueObject
    {
        return $this->rentingEndDateTo;
    }

    /**
     * @return SaleMethodCollection|null
     */
    public function getSaleMethodCollection(): ?SaleMethodCollection
    {
        return $this->saleMethodCollection;
    }

    /**
     * @return DateValueObject|null
     */
    public function getCheckInDateFrom(): ?DateValueObject
    {
        return $this->checkInDateFrom;
    }

    /**
     * @return VehicleStatusCollection|null
     */
    public function getVehicleStatusCollection(): ?VehicleStatusCollection
    {
        return $this->vehicleStatusCollection;
    }

    /**
     * @return bool|null
     */
    public function isConnectedVehicle(): ?bool
    {
        return $this->connectedVehicle;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        $vehicleTypeArray = [];
        if (!empty($this->getVehicleTypeCollection())) {
            /**
             * @var VehicleType $vehicleType
             */
            foreach ($this->getVehicleTypeCollection() as $vehicleType) {
                $vehicleTypeArray[] = $vehicleType->toArray();
            }
        }

        $brandArray = [];
        if (!empty($this->getBrandCollection())) {
            /**
             * @var Brand $brand
             */
            foreach ($this->getBrandCollection() as $brand) {
                $brandArray[] = $brand->toArray();
            }
        }

        $modelArray = [];
        if (!empty($this->getModelCollection())) {
            /**
             * @var Model $model
             */
            foreach ($this->getModelCollection() as $model) {
                $modelArray[] = $model->toArray();
            }
        }

        $vehicleGroupArray = [];
        if (!empty($this->getCarGroupCollection())) {
            /**
             * @var CarGroup $carGroup
             */
            foreach ($this->getCarGroupCollection() as $carGroup) {
                $vehicleGroupArray[] = $carGroup->toArray();
            }
        }

        $saleMethodArray = [];
        if (!empty($this->getSaleMethodCollection())) {
            /**
             * @var SaleMethod $saleMethod
             */
            foreach ($this->getSaleMethodCollection() as $saleMethod) {
                $saleMethodArray[] = $saleMethod->toArray();
            }
        }

        $vehicleStatusArray = [];
        if (!empty($this->getVehicleStatusCollection())) {
            /**
             * @var VehicleStatus $vehicleStatus
             */
            foreach ($this->getVehicleStatusCollection() as $vehicleStatus) {
                $vehicleStatusArray[] = $vehicleStatus->toArray();
            }
        }

        return [
            'VEHICLETYPE' => $vehicleTypeArray,
            'VEHICLEBRAND' => $brandArray,
            'VEHICLEMODEL' => $modelArray,
            'VEHICLEGROUP' => $vehicleGroupArray,
            'SALEMETHOD' => $saleMethodArray,
            'VEHICLEKMFROM' => $this->getKilometersFrom(),
            'VEHICLEKMTO' => $this->getKilometersTo(),
            'RENTENDDATEFROM' => $this->getRentingEndDateFrom() ? Utils::formatStringDateTimeToOdataDate($this->getRentingEndDateFrom()->__toString()) : null,
            'RENTENDDATETO' => $this->getRentingEndDateTo() ? Utils::formatStringDateTimeToOdataDate($this->getRentingEndDateTo()->__toString()) : null,
            'RAENDDATE' => $this->getCheckInDateFrom() ? Utils::formatStringDateTimeToOdataDate($this->getCheckInDateFrom()->__toString()) : null,
            'VEHICLESTATUS' => $vehicleStatusArray,
            'INCLUDECONECTED' => is_bool($this->isConnectedVehicle()) ? ($this->isConnectedVehicle() ? 1 : 0) : null
        ];
    }
}
