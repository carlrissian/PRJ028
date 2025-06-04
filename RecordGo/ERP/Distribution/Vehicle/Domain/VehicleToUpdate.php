<?php

namespace Distribution\Vehicle\Domain;

use Shared\Utils\Utils;
use Distribution\SaleMethod\Domain\SaleMethod;
use Shared\Domain\ValueObject\DateValueObject;
use Distribution\VehicleStatus\Domain\VehicleStatus;
use Distribution\PurchaseMethod\Domain\PurchaseMethod;

class VehicleToUpdate
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $licensePlate;

    /**
     * @var string|null
     */
    private $vin;

    /**
     * @var PurchaseMethod|null
     */
    private $purchaseMethod;

    /**
     * @var SaleMethod|null
     */
    private $saleMethod;

    /**
     * @var VehicleStatus|null
     */
    private $vehicleStatus;

    /**
     * @var Location|null
     */
    private $location;

    /**
     * @var DateValueObject|null
     */
    private $returnDate;

    /**
     * @var DateValueObject|null
     */
    private $firstRentDate;

    /**
     * @var DateValueObject|null
     */
    private $rentingEndDate;

    /**
     * @var DateValueObject|null
     */
    private $initBlockDate;

    /**
     * @var DateValueObject|null
     */
    private $endBlockDate;

    /**
     * VehicleToUpdate constructor.
     *
     * @param integer $id
     * @param string|null $licensePlate
     * @param string|null $vin
     * @param PurchaseMethod|null $purchaseMethod
     * @param SaleMethod|null $saleMethod
     * @param VehicleStatus|null $vehicleStatus
     * @param Location|null $location
     * @param DateValueObject|null $returnDate
     * @param DateValueObject|null $firstRentDate
     * @param DateValueObject|null $rentingEndDate
     * @param DateValueObject|null $initBlockDate
     * @param DateValueObject|null $endBlockDate
     */
    public function __construct(
        int $id,
        ?string $licensePlate,
        ?string $vin,
        ?PurchaseMethod $purchaseMethod,
        ?SaleMethod $saleMethod,
        ?VehicleStatus $vehicleStatus,
        ?Location $location,
        ?DateValueObject $returnDate,
        ?DateValueObject $firstRentDate,
        ?DateValueObject $rentingEndDate,
        ?DateValueObject $initBlockDate,
        ?DateValueObject $endBlockDate
    ) {
        $this->id = $id;
        $this->licensePlate = $licensePlate;
        $this->vin = $vin;
        $this->purchaseMethod = $purchaseMethod;
        $this->saleMethod = $saleMethod;
        $this->vehicleStatus = $vehicleStatus;
        $this->location = $location;
        $this->returnDate = $returnDate;
        $this->firstRentDate = $firstRentDate;
        $this->rentingEndDate = $rentingEndDate;
        $this->initBlockDate = $initBlockDate;
        $this->endBlockDate = $endBlockDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    /**
     * @return string|null
     */
    public function getVin(): ?string
    {
        return $this->vin;
    }

    /**
     * @return PurchaseMethod|null
     */
    public function getPurchaseMethod(): ?PurchaseMethod
    {
        return $this->purchaseMethod;
    }

    /**
     * @return SaleMethod|null
     */
    public function getSaleMethod(): ?SaleMethod
    {
        return $this->saleMethod;
    }

    /**
     * @return VehicleStatus|null
     */
    public function getVehicleStatus(): ?VehicleStatus
    {
        return $this->vehicleStatus;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @return DateValueObject|null
     */
    public function getReturnDate(): ?DateValueObject
    {
        return $this->returnDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getFirstRentDate(): ?DateValueObject
    {
        return $this->firstRentDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getRentingEndDate(): ?DateValueObject
    {
        return $this->rentingEndDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getInitBlockDate(): ?DateValueObject
    {
        return $this->initBlockDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getEndBlockDate(): ?DateValueObject
    {
        return $this->endBlockDate;
    }


    /**
     * @param array|null $vehicleArray
     * @return VehicleToUpdate
     */
    public static function createFromArray(?array $vehicleArray): VehicleToUpdate
    {
        return new self(
            intval($vehicleArray['ID']),
            $vehicleArray['LICENSEPLATE'] ?? null,
            $vehicleArray['VIN'] ?? null,
            (isset($vehicleArray['PURCHASEMETHOD'])) ? PurchaseMethod::createFromArray($vehicleArray['PURCHASEMETHOD']) : null,
            (isset($vehicleArray['SALEMETHOD'])) ? SaleMethod::createFromArray($vehicleArray['SALEMETHOD']) : null,
            (isset($vehicleArray['VEHICLESTATUS'])) ? VehicleStatus::createFromArray($vehicleArray['VEHICLESTATUS']) : null,
            (isset($vehicleArray['LOCATION'])) ? Location::createFromArray($vehicleArray['LOCATION']) : null,
            (isset($vehicleArray['RETURNDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RETURNDATE'])) : null,
            (isset($vehicleArray['FIRSTRENTDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['FIRSTRENTDATE'])) : null,
            (isset($vehicleArray['RENTINGENDDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RENTINGENDDATE'])) : null,
            (isset($vehicleArray['INITBLOCKDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['INITBLOCKDATE'])) : null,
            (isset($vehicleArray['ENDBLOCKDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['ENDBLOCKDATE'])) : null
        );
    }
}
