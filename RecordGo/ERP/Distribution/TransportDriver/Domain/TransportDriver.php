<?php

declare(strict_types=1);

namespace Distribution\TransportDriver\Domain;

use Shared\Utils\Utils;
use Shared\Utils\DataValidation;
use Shared\Domain\ValueObject\DateValueObject;

class TransportDriver
{
    /**
     *
     * @var int|null
     */
    private $id;

    /**
     * El conductor es interno o externo
     *
     * @var bool
     */
    private $internalDriver;

    /**
     *
     * @var int|null
     */
    private $transportProviderId;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string
     */
    private $lastName;

    /**
     * Número de documento de identificación o pasaporte
     *
     * @var string
     */
    private $idNumber;

    /**
     * Número de carnet de conducir
     *
     * @var string
     */
    private $driverLicense;

    /**
     * Fecha de emisión del permiso
     *
     * @var DateValueObject
     */
    private $issueDate;

    /**
     * Fecha de expiración del permiso
     *
     * @var DateValueObject
     */
    private $expirationDate;

    /**
     *
     * @var string
     */
    private $address;

    /**
     *
     * @var int|null
     */
    private ?int $postalCode;

    /**
     * Ciudad del permiso
     *
     * @var string
     */
    private $city;

    /**
     * Estado o provincia del permiso
     *
     * @var string
     */
    private ?string $state;


    /**
     * País del permiso
     *
     * @var Country
     */
    private $country;

    /**
     * Delegación habitual
     *
     * @var int|null
     */
    private $branchId;

    /**
     * TransportDriver constructor.
     *
     * @param integer|null $id
     * @param boolean $internalDriver
     * @param integer|null $transportProviderId
     * @param string $name
     * @param string $lastName
     * @param string $idNumber
     * @param string $driverLicense
     * @param DateValueObject $issueDate
     * @param DateValueObject $expirationDate
     * @param string $address
     * @param integer|null $postalCode
     * @param string $city
     * @param string $state
     * @param Country $country
     * @param int|null $branchId
     */
    public function __construct(
        ?int $id,
        bool $internalDriver,
        ?int $transportProviderId,
        string $name,
        string $lastName,
        string $idNumber,
        string $driverLicense,
        DateValueObject $issueDate,
        DateValueObject $expirationDate,
        string $address,
        ?int $postalCode,
        string $city,
        ?string $state,
        Country $country,
        ?int $branchId
    ) {
        $this->id = $id;
        $this->internalDriver = $internalDriver;
        $this->transportProviderId = $transportProviderId;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->idNumber = $idNumber;
        $this->driverLicense = $driverLicense;
        $this->issueDate = $issueDate;
        $this->expirationDate = $expirationDate;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->state = $state ?? '';
        $this->country = $country;
        $this->branchId = $branchId;
    }

    /**
     * Get the value of id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get el conductor es interno o externo
     *
     * @return bool
     */
    public function isInternalDriver(): bool
    {
        return $this->internalDriver;
    }

    /**
     * Get the value of transportProviderId
     *
     * @return int|null
     */
    public function getTransportProviderId(): ?int
    {
        return $this->transportProviderId;
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
     * Get número de documento de identificación o pasaporte
     *
     * @return string
     */
    public function getIdNumber(): string
    {
        return $this->idNumber;
    }

    /**
     * Get número de carnet de conducir
     *
     * @return string
     */
    public function getDriverLicense(): string
    {
        return $this->driverLicense;
    }

    /**
     * Get fecha de emisión del permiso
     *
     * @return DateValueObject
     */
    public function getIssueDate(): DateValueObject
    {
        return $this->issueDate;
    }

    /**
     * Get fecha de expiración del permiso
     *
     * @return DateValueObject
     */
    public function getExpirationDate(): DateValueObject
    {
        return $this->expirationDate;
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
     * Get the value of postalCode
     *
     * @return int|null
     */
    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    /**
     * Get ciudad del permiso
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Get estado o provincia del permiso
     *
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * Get país del permiso
     *
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * Get delegación habitual
     *
     * @return int|null
     */
    public function getBranchId(): ?int
    {
        return $this->branchId;
    }


    /**
     * @param array|null $transportDriverArray
     * @return TransportDriver
     */
    public static function createFromArray(?array $transportDriverArray): TransportDriver
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($transportDriverArray, 'ID')),
            $helper->boolOrNull($helper->arrayExistOrNull($transportDriverArray, 'INTERNALDRIVER')),
            $helper->intOrNull($helper->arrayExistOrNull($transportDriverArray, 'TRANSPROVIDERID')),
            $helper->arrayExistOrNull($transportDriverArray, 'EXTDRIVERSNAME'),
            $helper->arrayExistOrNull($transportDriverArray, 'EXTDRIVERSLASTNAME'),
            $helper->arrayExistOrNull($transportDriverArray, 'EXTDRIVERIDNUM'),
            $helper->arrayExistOrNull($transportDriverArray, 'EXTDRIVERDL'),
            (isset($transportDriverArray['DLISSUEDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($transportDriverArray['DLISSUEDATE'])) : null,
            (isset($transportDriverArray['DLEXPIRATIONDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($transportDriverArray['DLEXPIRATIONDATE'])) : null,
            $helper->arrayExistOrNull($transportDriverArray, 'EXTDRIVERADD'),
            $helper->intOrNull($helper->arrayExistOrNull($transportDriverArray, 'EXTDRIVERPC')),
            $helper->arrayExistOrNull($transportDriverArray, 'EXTDRIVERCITY'),
            $helper->arrayExistOrNull($transportDriverArray, 'DRIVERSTATE'),
            (isset($transportDriverArray['Country'])) ? Country::createFromArray($transportDriverArray['Country']) : null,
            $helper->intOrNull($helper->arrayExistOrNull($transportDriverArray, 'BRANCHID'))
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            "INTERNALDRIVER" => $this->isInternalDriver() ? 1 : 0,
            "TRANSPROVIDERID" => $this->getTransportProviderId(),
            "EXTDRIVERSNAME" => $this->getName(),
            "EXTDRIVERSLASTNAME" => $this->getLastName(),
            "EXTDRIVERIDNUM" => $this->getIdNumber(),
            "EXTDRIVERDL" => $this->getDriverLicense(),
            "DLISSUEDATE" => Utils::formatStringDateTimeToOdataDate($this->getIssueDate()->__toString()),
            "DLEXPIRATIONDATE" => Utils::formatStringDateTimeToOdataDate($this->getExpirationDate()->__toString()),
            "EXTDRIVERADD" => $this->getAddress(),
            "EXTDRIVERPC" => $this->getPostalCode(),
            "EXTDRIVERCITY" => $this->getCity(),
            "DRIVERSTATE" => $this->getState(),
            "EXTDRIVERCOUNTRYID" => $this->getCountry() ? $this->getCountry()->getId() : null,
            "BRANCHID" => $this->getBranchId(),
        ];
    }
}
