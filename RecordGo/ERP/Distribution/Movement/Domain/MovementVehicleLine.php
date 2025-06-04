<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Domain\User;
use Shared\Domain\ValueObject\DateTimeValueObject;

class MovementVehicleLine
{
    /**
     * @var int
     */
    private $movementId;

    /**
     * @var string|null
     */
    private $orderNumber;

    /**
     * @var BusinessUnit|null
     */
    private $businessUnit;

    /**
     * @var BusinessUnitArticle|null
     */
    private $businessUnitArticle;

    /**
     * @var Supplier|null
     */
    private $supplier;

    /**
     * @var VehicleLineCollection|null
     */
    private $vehicleLines;

    /**
     * @var Location|null
     */
    private $originLocaion;

    /**
     * @var ManualLocation|null
     */
    private $manualOriginLocation;

    /**
     * @var Location|null
     */
    private $destinationLocation;

    /**
     * @var ManualLocation|null
     */
    private $manualDestinationLocation;

    /**
     * @var DateTimeValueObject
     */
    private $expectedLoadDate;

    /**
     * @var DateTimeValueObject
     */
    private $expectedUnloadDate;

    /**
     * @var MovementStatus
     */
    private $movementStatus;

    /**
     * @var User
     */
    private $creationUser;

    /**
     * @var DateTimeValueObject
     */
    private $creationDate;


    /**
     * MovementVehicleLine constructor.
     *
     * @param integer $movementId
     * @param string|null $orderNumber
     * @param BusinessUnit|null $businessUnit
     * @param BusinessUnitArticle|null $businessUnitArticle
     * @param Supplier|null $supplier
     * @param VehicleLineCollection|null $vehicleLines
     * @param Location|null $originLocaion
     * @param ManualLocation|null $manualOriginLocation
     * @param Location|null $destinationLocation
     * @param ManualLocation|null $manualDestinationLocation
     * @param DateTimeValueObject $expectedLoadDate
     * @param DateTimeValueObject $expectedUnloadDate
     * @param MovementStatus $movementStatus
     * @param User $creationUser
     * @param DateTimeValueObject $creationDate
     */
    public function __construct(
        int $movementId,
        ?string $orderNumber,
        ?BusinessUnit $businessUnit,
        ?BusinessUnitArticle $businessUnitArticle,
        ?Supplier $supplier,
        ?VehicleLineCollection $vehicleLines,
        ?Location $originLocaion,
        ?ManualLocation $manualOriginLocation,
        ?Location $destinationLocation,
        ?ManualLocation $manualDestinationLocation,
        DateTimeValueObject $expectedLoadDate,
        DateTimeValueObject $expectedUnloadDate,
        MovementStatus $movementStatus,
        User $creationUser,
        DateTimeValueObject $creationDate
    ) {
        $this->movementId = $movementId;
        $this->orderNumber = $orderNumber;
        $this->businessUnit = $businessUnit;
        $this->businessUnitArticle = $businessUnitArticle;
        $this->supplier = $supplier;
        $this->vehicleLines = $vehicleLines;
        $this->originLocaion = $originLocaion;
        $this->manualOriginLocation = $manualOriginLocation;
        $this->destinationLocation = $destinationLocation;
        $this->manualDestinationLocation = $manualDestinationLocation;
        $this->expectedLoadDate = $expectedLoadDate;
        $this->expectedUnloadDate = $expectedUnloadDate;
        $this->movementStatus = $movementStatus;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

    /**
     * @return string|null
     */
    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    /**
     * @return BusinessUnit|null
     */
    public function getBusinessUnit(): ?BusinessUnit
    {
        return $this->businessUnit;
    }

    /**
     * @return BusinessUnitArticle|null
     */
    public function getBusinessUnitArticle(): ?BusinessUnitArticle
    {
        return $this->businessUnitArticle;
    }

    /**
     * @return Supplier|null
     */
    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    /**
     * @return VehicleLineCollection|null
     */
    public function getVehicleLines(): ?VehicleLineCollection
    {
        return $this->vehicleLines;
    }

    /**
     * @return Location|null
     */
    public function getOriginLocaion(): ?Location
    {
        return $this->originLocaion;
    }

    /**
     * @return ManualLocation|null
     */
    public function getManualOriginLocation(): ?ManualLocation
    {
        return $this->manualOriginLocation;
    }

    /**
     * @return Location|null
     */
    public function getDestinationLocation(): ?Location
    {
        return $this->destinationLocation;
    }

    /**
     * @return ManualLocation|null
     */
    public function getManualDestinationLocation(): ?ManualLocation
    {
        return $this->manualDestinationLocation;
    }

    /**
     * @return DateTimeValueObject
     */
    public function getExpectedLoadDate(): DateTimeValueObject
    {
        return $this->expectedLoadDate;
    }

    /**
     * @return DateTimeValueObject
     */
    public function getExpectedUnloadDate(): DateTimeValueObject
    {
        return $this->expectedUnloadDate;
    }

    /**
     * @return MovementStatus
     */
    public function getMovementStatus(): MovementStatus
    {
        return $this->movementStatus;
    }

    /**
     * @return User
     */
    public function getCreationUser(): User
    {
        return $this->creationUser;
    }

    /**
     * @return DateTimeValueObject
     */
    public function getCreationDate(): DateTimeValueObject
    {
        return $this->creationDate;
    }
}
