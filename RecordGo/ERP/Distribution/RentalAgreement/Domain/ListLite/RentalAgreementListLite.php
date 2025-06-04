<?php

namespace Distribution\RentalAgreement\Domain\ListLite;

use Shared\Utils\Utils;
use Distribution\RentalAgreement\Domain\Acriss;
use Distribution\RentalAgreement\Domain\Branch;
use Distribution\RentalAgreement\Domain\Booking;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Distribution\RentalAgreement\Domain\SalesDocStatus;

final class RentalAgreementListLite
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $raSearchCode;

    /**
     * @var string|null
     */
    private ?string $partnerSearchCode;

    /**
     * @var Booking|null
     */
    private ?Booking $booking;

    /**
     * @var Customer|null
     */
    private ?Customer $customer;

    /**
     * @var BookingAnnexe|null
     */
    private ?BookingAnnexe $bookingAnnexe;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $pickUpDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $dropOffDate;

    /**
     * @var Branch|null
     */
    private ?Branch $branchPickUp;

    /**
     * @var Branch|null
     */
    private ?Branch $branchDropOff;

    /**
     * @var Acriss|null
     */
    private ?Acriss $acriss;

    /**
     * @var SalesDocStatus|null
     */
    private ?SalesDocStatus $salesDocStatus;

    /**
     * RentalAgreementListLite constructor.
     *
     * @param integer $id
     * @param string|null $raSearchCode
     * @param string|null $partnerSearchCode
     * @param Booking|null $booking
     * @param Customer|null $customer
     * @param BookingAnnexe|null $bookingAnnexe
     * @param DateTimeValueObject|null $pickUpDate
     * @param DateTimeValueObject|null $dropOffDate
     * @param Branch|null $branchPickUp
     * @param Branch|null $branchDropOff
     * @param Acriss|null $acriss
     * @param SalesDocStatus|null $salesDocStatus
     */
    public function __construct(
        int $id,
        ?string $raSearchCode,
        ?string $partnerSearchCode,
        ?Booking $booking,
        ?Customer $customer,
        ?BookingAnnexe $bookingAnnexe,
        ?DateTimeValueObject $pickUpDate,
        ?DateTimeValueObject $dropOffDate,
        ?Branch $branchPickUp,
        ?Branch $branchDropOff,
        ?Acriss $acriss,
        ?SalesDocStatus $salesDocStatus
    ) {
        $this->id = $id;
        $this->raSearchCode = $raSearchCode;
        $this->partnerSearchCode = $partnerSearchCode;
        $this->booking = $booking;
        $this->customer = $customer;
        $this->bookingAnnexe = $bookingAnnexe;
        $this->pickUpDate = $pickUpDate;
        $this->dropOffDate = $dropOffDate;
        $this->branchPickUp = $branchPickUp;
        $this->branchDropOff = $branchDropOff;
        $this->acriss = $acriss;
        $this->salesDocStatus = $salesDocStatus;
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
    public function getRaSearchCode(): ?string
    {
        return $this->raSearchCode;
    }

    /**
     * @return string|null
     */
    public function getPartnerSearchCode(): ?string
    {
        return $this->partnerSearchCode;
    }

    /**
     * @return Booking|null
     */
    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @return BookingAnnexe|null
     */
    public function getBookingAnnexe(): ?BookingAnnexe
    {
        return $this->bookingAnnexe;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getPickUpDate(): ?DateTimeValueObject
    {
        return $this->pickUpDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getDropOffDate(): ?DateTimeValueObject
    {
        return $this->dropOffDate;
    }

    /**
     * @return Branch|null
     */
    public function getBranchPickUp(): ?Branch
    {
        return $this->branchPickUp;
    }

    /**
     * @return Branch|null
     */
    public function getBranchDropOff(): ?Branch
    {
        return $this->branchDropOff;
    }

    /**
     * @return Acriss|null
     */
    public function getAcriss(): ?Acriss
    {
        return $this->acriss;
    }

    /**
     * @return SalesDocStatus|null
     */
    public function getSalesDocStatus(): ?SalesDocStatus
    {
        return $this->salesDocStatus;
    }


    /**
     * @param array $rentalAgreementArray
     * @return self
     */
    public static function createFromArray(?array $rentalAgreementArray): self
    {
        return new self(
            intval($rentalAgreementArray['ID']),
            $rentalAgreementArray['RASEARCHCODE'] ?? null,
            $rentalAgreementArray['PARTNERSEARCHCODE'] ?? null,
            (isset($rentalAgreementArray['Booking'])) ? Booking::createFromArray($rentalAgreementArray['Booking']) : null,
            (isset($rentalAgreementArray['Customer'])) ? Customer::createFromArray($rentalAgreementArray['Customer']) : null,
            (isset($rentalAgreementArray['BookingAnnexe'])) ? BookingAnnexe::createFromArray($rentalAgreementArray['BookingAnnexe']) : null,
            (isset($rentalAgreementArray['PICKUPDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($rentalAgreementArray['PICKUPDATE'])) : null,
            (isset($rentalAgreementArray['DROPOFFDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($rentalAgreementArray['DROPOFFDATE'])) : null,
            (isset($rentalAgreementArray['PickUpBranch'])) ? Branch::createFromArray($rentalAgreementArray['PickUpBranch']) : null,
            (isset($rentalAgreementArray['BranchDropOff'])) ? Branch::createFromArray($rentalAgreementArray['BranchDropOff']) : null,
            (isset($rentalAgreementArray['Acriss'])) ? Acriss::createFromArray($rentalAgreementArray['Acriss']) : null,
            (isset($rentalAgreementArray['SalesDocStatus'])) ? SalesDocStatus::createFromArray($rentalAgreementArray['SalesDocStatus']) : null
        );
    }
}
