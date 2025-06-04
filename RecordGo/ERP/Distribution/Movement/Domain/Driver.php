<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Utils\Utils;
use Shared\Utils\DataValidation;
use Shared\Domain\ValueObject\DateValueObject;

class Driver
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $lastName;

    /**
     * @var string|null
     */
    private ?string $idNumber;

    /**
     * @var string|null
     */
    private ?string $driverLicense;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $driverLicenseIssueDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $driverLicenseExpirationDate;

    /**
     * @var string|null
     */
    private ?string $address;

    /**
     * @var string|null
     */
    private ?string $state;

    /**
     * @var string|null
     */
    private ?string $city;

    /**
     * @var string|null
     */
    private ?string $postalCode;

    /**
     * @var Country|null
     */
    private ?Country $country;

    /**
     * @var int|null
     */
    private ?int $branchId;

    /**
     * @var int|null
     */
    private ?int $providerid;

    /**
     * Driver constructor.
     *
     * @param integer $id
     * @param string|null $name
     * @param string|null $lastName
     * @param string|null $idNumber
     * @param string|null $driverLicense
     * @param DateValueObject|null $driverLicenseIssueDate
     * @param DateValueObject|null $driverLicenseExpirationDate
     * @param string|null $address
     * @param string|null $state
     * @param string|null $city
     * @param string|null $postalCode
     * @param Country|null $country
     * @param integer|null $branchId
     * @param integer|null $providerid
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $lastName = null,
        ?string $idNumber = null,
        ?string $driverLicense = null,
        ?DateValueObject $driverLicenseIssueDate = null,
        ?DateValueObject $driverLicenseExpirationDate = null,
        ?string $address = null,
        ?string $state = null,
        ?string $city = null,
        ?string $postalCode = null,
        ?Country $country = null,
        ?int $branchId = null,
        ?int $providerid = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->idNumber = $idNumber;
        $this->driverLicense = $driverLicense;
        $this->driverLicenseIssueDate = $driverLicenseIssueDate;
        $this->driverLicenseExpirationDate = $driverLicenseExpirationDate;
        $this->address = $address;
        $this->state = $state;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->country = $country;
        $this->branchId = $branchId;
        $this->providerid = $providerid;
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
    public function getDriverLicenseIsueDate(): ?DateValueObject
    {
        return $this->driverLicenseIssueDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getDriverLicenseExpirationDate(): ?DateValueObject
    {
        return $this->driverLicenseExpirationDate;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @return int|null
     */
    public function getBranchId(): ?int
    {
        return $this->branchId;
    }

    /**
     * @return int|null
     */
    public function getProviderId(): ?int
    {
        return $this->providerid;
    }


    /**
     * @param array $driverArray
     * @return Driver
     */
    public static function createFromArray(array $driverArray): Driver
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($driverArray, 'ID')),
            $helper->arrayExistOrNull($driverArray, 'EXTDRIVERSNAME'),
            $helper->arrayExistOrNull($driverArray, 'EXTDRIVERSLASTNAME'),
            $helper->arrayExistOrNull($driverArray, 'EXTDRIVERIDNUM'),
            $helper->arrayExistOrNull($driverArray, 'EXTDRIVERDL'),
            isset($driverArray['DLISSUEDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($driverArray['DLISSUEDATE'])) : null,
            isset($driverArray['DLEXPIRATIONDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($driverArray['DLEXPIRATIONDATE'])) : null,
            $helper->arrayExistOrNull($driverArray, 'EXTDRIVERADD'),
            $helper->arrayExistOrNull($driverArray, 'DRIVERSTATE'),
            $helper->arrayExistOrNull($driverArray, 'EXTDRIVERCITY'),
            $helper->arrayExistOrNull($driverArray, 'EXTDRIVERPC'),
            $driverArray['DRIVERCOUNTRY'] ? Country::createFromArray($driverArray['DRIVERCOUNTRY']) : null,
            $helper->intOrNull($helper->arrayExistOrNull($driverArray, 'BRANCHID')),
            $helper->intOrNull($helper->arrayExistOrNull($driverArray, 'TRANSPORTPROVIDERID'))
        );
    }
}
