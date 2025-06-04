<?php

namespace Distribution\TransportDriver\Application\FilterTransportDriver;

use Shared\Domain\ValueObject\DateValueObject;

class FilterTransportDriverQuery
{
    /**
     * @var string|null
     */
    private $sortBy;

    /**
     * @var string|null
     */
    private $order;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var int|null
     */
    private $limit;
    /**
     *
     * @var string|null
     */
    private $name;

    /**
     *
     * @var string|null
     */
    private $lastName;

    /**
     *
     * @var string|null
     */
    private $idNumber;

    /**
     *
     * @var string|null
     */
    private $driverLicense;

    /**
     *
     * @var DateValueObject|null
     */
    private $issueDate;

    /**
     *
     * @var DateValueObject|null
     */
    private $expiringDate;

    /**
     *
     * @var string|null
     */
    private $city;

    /**
     *
     * @var int|null
     */
    private $countryId;

    /**
     * @param string|null $sortBy
     * @param string|null $order
     * @param int|null $offset
     * @param int|null $limit
     * @param string|null $name
     * @param string|null $lastName
     * @param string|null $idNumber
     * @param string|null $driverLicense
     * @param DateValueObject|null $issueDate
     * @param DateValueObject|null $expiringDate
     * @param string|null $city
     * @param int|null $countryId
     */
    public function __construct(?string $sortBy, ?string $order, ?int $offset, ?int $limit, ?string $name, ?string $lastName, ?string $idNumber, ?string $driverLicense, ?DateValueObject $issueDate, ?DateValueObject $expiringDate, ?string $city, ?int $countryId)
    {
        $this->sortBy = $sortBy;
        $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->idNumber = $idNumber;
        $this->driverLicense = $driverLicense;
        $this->issueDate = $issueDate;
        $this->expiringDate = $expiringDate;
        $this->city = $city;
        $this->countryId = $countryId;
    }

    /**
     * @return string|null
     */
    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    /**
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getIdNumber(): ?string
    {
        return $this->idNumber;
    }

    /**
     * @return string|null
     */
    public function getDriverLicense(): ?string
    {
        return $this->driverLicense;
    }

    /**
     * @return DateValueObject|null
     */
    public function getIssueDate(): ?DateValueObject
    {
        return $this->issueDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getExpiringDate(): ?DateValueObject
    {
        return $this->expiringDate;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return int|null
     */
    public function getCountryId(): ?int
    {
        return $this->countryId;
    }


}