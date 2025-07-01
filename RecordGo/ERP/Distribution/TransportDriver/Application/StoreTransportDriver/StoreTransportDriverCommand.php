<?php

namespace Distribution\TransportDriver\Application\StoreTransportDriver;

class StoreTransportDriverCommand
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $idNumber;

    /**
     * @var string
     */
    private $driverLicense;

    /**
     * @var string
     */
    private $issueDate;

    /**
     * @var string
     */
    private $expirationDate;

    /**
     * @var string
     */
    private $city;

    /**
     * @var int
     */
    private $stateId;

    /**
     * @var string|null
     */
    private $stateName;

    /**
     * @var int
     */
    private $countryId;

    /**
     * @var string|null
     */
    private $countryName;

    /**
     * @var integer
     */
    private $postalCode;

    /**
     * @var string
     */
    private $address;

    /**
     * @var bool
     */
    private $internalDriver;

    /**
     * @var int|null
     */
    private $providerId;

    /**
     * @var int
     */
    private $branchId;

    /**
     * @var string|null
     */
    private $branchName;

    /**
     * StoreTransportDriverCommand constructor.
     *
     * @param string $name
     * @param string $lastName
     * @param string $idNumber
     * @param string $driverLicense
     * @param string $issueDate
     * @param string $expirationDate
     * @param string $city
     * @param integer $stateId
     * @param string|null $stateName
     * @param integer $countryId
     * @param string|null $countryName
     * @param integer $postalCode
     * @param string $address
     * @param boolean $internalDriver
     * @param integer|null $providerId
     * @param integer $branchId
     * @param string|null $branchName
     */
    public function __construct(
        string $name,
        string $lastName,
        string $idNumber,
        string $driverLicense,
        string $issueDate,
        string $expirationDate,
        string $city,
        int $stateId,
        ?string $stateName,
        int $countryId,
        ?string $countryName,
        int $postalCode,
        string $address,
        bool $internalDriver,
        ?int $providerId,
        int $branchId,
        ?string $branchName
    ) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->idNumber = $idNumber;
        $this->driverLicense = $driverLicense;
        $this->issueDate = $issueDate;
        $this->expirationDate = $expirationDate;
        $this->city = $city;
        $this->stateId = $stateId;
        $this->stateName = $stateName;
        $this->countryId = $countryId;
        $this->countryName = $countryName;
        $this->postalCode = $postalCode;
        $this->address = $address;
        $this->internalDriver = $internalDriver;
        $this->providerId = $providerId;
        $this->branchId = $branchId;
        $this->branchName = $branchName;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of lastName
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Get the value of idNumber
     *
     * @return string
     */
    public function getIdNumber(): string
    {
        return $this->idNumber;
    }

    /**
     * Get the value of driverLicense
     *
     * @return string
     */
    public function getDriverLicense(): string
    {
        return $this->driverLicense;
    }

    /**
     * Get the value of issueDate
     *
     * @return string
     */
    public function getIssueDate(): string
    {
        return $this->issueDate;
    }

    /**
     * Get the value of expirationDate
     *
     * @return string
     */
    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }

    /**
     * Get the value of city
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Get the value of stateId
     *
     * @return int
     */
    public function getStateId(): int
    {
        return $this->stateId;
    }

    /**
     * Get the value of stateName
     *
     * @return string|null
     */
    public function getStateName(): ?string
    {
        return $this->stateName;
    }

    /**
     * Get the value of countryId
     *
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }

    /**
     * Get the value of countryName
     *
     * @return  string|null
     */
    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    /**
     * Get the value of postalCode
     *
     * @return integer
     */
    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    /**
     * Get the value of address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Get the value of internalDriver
     *
     * @return bool
     */
    public function isInternalDriver(): bool
    {
        return $this->internalDriver;
    }

    /**
     * Get the value of providerId
     *
     * @return int|null
     */
    public function getProviderId(): ?int
    {
        return $this->providerId;
    }

    /**
     * Get the value of branchId
     *
     * @return int
     */
    public function getBranchId(): int
    {
        return $this->branchId;
    }

    /**
     * Get the value of branchName
     *
     * @return string|null
     */
    public function getBranchName(): ?string
    {
        return $this->branchName;
    }
}
