<?php

namespace Distribution\RentalAgreement\Domain;

class Booking
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string Número de localizador de reserva
     */
    private string $bookingSearchCode;

    /**
     * @var SalesDocStatus|null
     */
    private ?SalesDocStatus $salesDocStatus;

    /**
     * @param int $id
     * @param string $bookingSearchCode
     * @param SalesDocStatus|null $salesDocStatus
     */
    public function __construct(
        int $id,
        string $bookingSearchCode,
        ?SalesDocStatus $salesDocStatus = null
    ) {
        $this->id = $id;
        $this->bookingSearchCode = $bookingSearchCode;
        $this->salesDocStatus = $salesDocStatus;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    final public function getBookingSearchCode(): string
    {
        return $this->bookingSearchCode;
    }

    /**
     * @return SalesDocStatus|null
     */
    final public function getSalesDocStatus(): ?SalesDocStatus
    {
        return $this->salesDocStatus;
    }


    /**
     * @param array $bookingArray
     * @return self
     */
    public static function createFromArray(array $bookingArray): self
    {
        return new self(
            $bookingArray['ID'],
            $bookingArray['BOOKINGSEARCHCODE'] ?? null,
            (isset($bookingArray['BookingStatus'])) ? SalesDocStatus::createFromArray($bookingArray['BookingStatus']) : null
        );
    }
}
