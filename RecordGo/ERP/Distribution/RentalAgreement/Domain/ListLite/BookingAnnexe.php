<?php

namespace Distribution\RentalAgreement\Domain\ListLite;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\RentalAgreement\Domain\SalesDocStatus;

final class BookingAnnexe
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $realPickupDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $realDropOffDate;

    /**
     * @var SalesDocStatus|null
     */
    private ?SalesDocStatus $salesDocStatus;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;

    /**
     * BookingAnnexe constructor.
     * 
     * @param int $id
     * @param DateTimeValueObject|null $realPickupDate
     * @param DateTimeValueObject|null $realDropOffDate
     * @param SalesDocStatus|null $salesDocStatus
     * @param DateTimeValueObject|null $creationDate
     */
    public function __construct(
        int $id,
        ?DateTimeValueObject $realPickupDate,
        ?DateTimeValueObject $realDropOffDate,
        ?SalesDocStatus $salesDocStatus,
        ?DateTimeValueObject $creationDate
    ) {
        $this->id = $id;
        $this->realPickupDate = $realPickupDate;
        $this->realDropOffDate = $realDropOffDate;
        $this->salesDocStatus = $salesDocStatus;
        $this->creationDate = $creationDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getRealPickupDate(): ?DateTimeValueObject
    {
        return $this->realPickupDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getRealDropOffDate(): ?DateTimeValueObject
    {
        return $this->realDropOffDate;
    }

    /**
     * @return SalesDocStatus|null
     */
    public function getSalesDocStatus(): ?SalesDocStatus
    {
        return $this->salesDocStatus;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }


    /**
     * @param array $bookingAnnexeArray
     * @return self
     */
    public static function createFromArray(array $bookingAnnexeArray): self
    {
        return new self(
            intval($bookingAnnexeArray['ID']),
            (isset($bookingAnnexeArray['VEHICLEPICKUPDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($bookingAnnexeArray['VEHICLEPICKUPDATE'])) : null,
            (isset($bookingAnnexeArray['VEHICLEDROPOFFDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($bookingAnnexeArray['VEHICLEDROPOFFDATE'])) : null,
            (isset($bookingAnnexeArray['BookingAnnexeStatus'])) ? SalesDocStatus::createFromArray($bookingAnnexeArray['BookingAnnexeStatus']) : null,
            (isset($bookingAnnexeArray['CREATIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($bookingAnnexeArray['CREATIONDATE'])) : null
        );
    }
}
