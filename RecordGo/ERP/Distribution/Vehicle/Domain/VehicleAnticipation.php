<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;

class VehicleAnticipation
{
    /**
     * @var int
     */
    private int $movementId;

    /**
     * @var Location|null
     */
    private ?Location $originLocation;

    /**
     * @var Location|null
     */
    private ?Location $destinationLocation;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $expectedLoadDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $expectedUnloadDate;

    /**
     * @var BusinessUnit|null
     */
    private ?BusinessUnit $businessUnit;

    /**
     * @var BusinessUnitArticle|null
     */
    private ?BusinessUnitArticle $businessUnitArticle;


    /**
     * VehicleAnticipation constructor.
     * 
     * @param int $movementId
     * @param int $vehicleId
     * @param Location|null $originLocation
     * @param Location|null $destinationLocation
     * @param DateValueObject|null $expectedLoadDate
     * @param DateValueObject|null $expectedUnloadDate
     * @param BusinessUnit|null $businessUnit
     * @param BusinessUnitArticle|null $businessUnitArticle
     */
    public function __construct(
        int $movementId,
        ?Location $originLocation,
        ?Location $destinationLocation,
        ?DateValueObject $expectedLoadDate,
        ?DateValueObject $expectedUnloadDate,
        ?BusinessUnit $businessUnit,
        ?BusinessUnitArticle $businessUnitArticle
    ) {
        $this->movementId = $movementId;
        $this->originLocation = $originLocation;
        $this->destinationLocation = $destinationLocation;
        $this->expectedLoadDate = $expectedLoadDate;
        $this->expectedUnloadDate = $expectedUnloadDate;
        $this->businessUnit = $businessUnit;
        $this->businessUnitArticle = $businessUnitArticle;
    }


    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

    /**
     * @return Location|null
     */
    public function getOriginLocation(): ?Location
    {
        return $this->originLocation;
    }

    /**
     * @return Location|null
     */
    public function getDestinationLocation(): ?Location
    {
        return $this->destinationLocation;
    }

    /**
     * @return DateValueObject|null
     */
    public function getExpectedLoadDate(): ?DateValueObject
    {
        return $this->expectedLoadDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getExpectedUnloadDate(): ?DateValueObject
    {
        return $this->expectedUnloadDate;
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
     * @param array|null $vehicleAnticipationArray
     * @return self
     */
    public static function createFromArray(?array $vehicleAnticipationArray): self
    {
        return new self(
            intval($vehicleAnticipationArray['ID']),
            (isset($vehicleAnticipationArray['ORIGINLOCATION'])) ? Location::createFromArray($vehicleAnticipationArray['ORIGINLOCATION']) : null,
            (isset($vehicleAnticipationArray['DESTINATIONLOCATION'])) ? Location::createFromArray($vehicleAnticipationArray['DESTINATIONLOCATION']) : null,
            (isset($vehicleAnticipationArray['ESTIMATEDDEPARTURE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleAnticipationArray['ESTIMATEDDEPARTURE'])) : null,
            (isset($vehicleAnticipationArray['ESTIMATEDARRIVAL'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleAnticipationArray['ESTIMATEDARRIVAL'])) : null,
            (isset($vehicleAnticipationArray['BUSINESSUNIT'])) ? BusinessUnit::createFromArray($vehicleAnticipationArray['BUSINESSUNIT']) : null,
            (isset($vehicleAnticipationArray['BUSINESSUNITARTICLE'])) ? BusinessUnitArticle::createFromArray($vehicleAnticipationArray['BUSINESSUNITARTICLE']) : null
        );
    }
}
