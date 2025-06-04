<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterMovementVehicles;

class FilterMovementVehiclesQuery
{

    /**
     * @var int|null
     */
    private ?int $movementTypeId;

    /**
     * @var array|null
     */
    private ?array $movementCategory;

    /**
     * @var array|null
     */
    private ?array $movementStatusId;

    /**
     * @var array|null
     */
    private ?array $id;

    /**
     * @var array|null
     */
    private ?array $orderNumber;

    /**
     * @var bool|null
     */
    private ?bool $extTransport;

    /**
     * @var string|null
     */
    private ?string $licensePlate;

    /**
     * @var string|null
     */
    private ?string $vin;


    /**
     * @var array|null
     */
    private ?array $brandId;

    /**
     * @var array|null
     */
    private ?array $modelId;

    /**
     * @var array|null
     */
    private ?array $supplierCode;

    /**
     * @var array|null
     */
    private ?array $originLocationId;

    /**
     * @var array|null
     */
    private ?array $manualOriginLocation;

    /**
     * @var array|null
     */
    private ?array $destinationLocationId;

    /**
     * @var array|null
     */
    private ?array $manualDestinationLocation;

    /**
     * @var array|null
     */
    private ?array $originBranchId;

    /**
     * @var array|null
     */
    private ?array $destinationBranchId;

    /**
     * @var array|null
     */
    private ?array $businessUnitId;

    /**
     * @var array|null
     */
    private ?array $businessUnitArticleId;

    /**
     * @var string|null
     */
    private ?string $expectedLoadDate;

    /**
     * @var string|null
     */
    private ?string $actualLoadDate;

    /**
     * @var string|null
     */
    private ?string $expectedUnloadDate;

    /**
     * @var string|null
     */
    private ?string $actualUnloadDate;

    /**
     * @var string|null
     */
    private ?string $checkOutDateFrom;

    /**
     * @var string|null
     */
    private ?string $checkOutDateTo;


    /**
     * @var string|null
     */
    private ?string $expectedLoadDateFrom;

    /**
     * @var string|null
     */
    private ?string $expectedLoadDateTo;

    /**
     * @var string|null
     */
    private ?string $expectedUnloadDateFrom;

    /**
     * @var string|null
     */
    private ?string $expectedUnloadDateTo;


    /**
     * @var string|null
     */
    private ?string $loadDateFrom;

    /**
     * @var string|null
     */
    private ?string $loadDateTo;

    /**
     * @var string|null
     */
    private ?string $unloadDateFrom;

    /**
     * @var string|null
     */
    private ?string $unloadDateTo;

    /**
     * @var array|null
     */
    private ?array $creationUser;

    /**
     * @var string|null
     */
    private ?string $creationDate;

    /**
     * FilterMovementQuery constructor.
     *
     * @param integer|null $movementTypeId
     * @param array|null $movementCategory
     * @param array|null $movementStatusId
     * @param array|null $id
     * @param array|null $orderNumber
     * @param boolean|null $extTransport
     * @param string|null $licensePlate
     * @param string|null $vin
     * @param array|null $brandId
     * @param array|null $modelId
     * @param array|null $supplierCode
     * @param array|null $originLocationId
     * @param array|null $manualOriginLocation
     * @param array|null $destinationLocationId
     * @param array|null $manualDestinationLocation
     * @param array|null $originBranchId
     * @param array|null $destinationBranchId
     * @param array|null $businessUnitId
     * @param array|null $businessUnitArticleId
     * @param string|null $expectedLoadDate
     * @param string|null $actualLoadDate
     * @param string|null $expectedUnloadDate
     * @param string|null $actualUnloadDate
     * @param string|null $checkOutDateFrom
     * @param string|null $checkOutDateTo
     * @param string|null $expectedLoadDateFrom
     * @param string|null $expectedLoadDateTo
     * @param string|null $expectedUnloadDateFrom
     * @param string|null $expectedUnloadDateTo
     * @param string|null $loadDateFrom
     * @param string|null $loadDateTo
     * @param string|null $unloadDateFrom
     * @param string|null $unloadDateTo
     * @param array|null $creationUser
     * @param string|null $creationDate
     */
    public function __construct(
        ?int $movementTypeId,
        ?array $movementCategory,
        ?array $movementStatusId,
        ?array $id,
        ?array $orderNumber,
        ?bool $extTransport,
        ?string $licensePlate,
        ?string $vin,
        ?array $brandId,
        ?array $modelId,
        ?array $supplierCode,
        ?array $originLocationId,
        ?array $manualOriginLocation,
        ?array $destinationLocationId,
        ?array $manualDestinationLocation,
        ?array $originBranchId,
        ?array $destinationBranchId,
        ?array $businessUnitId,
        ?array $businessUnitArticleId,
        ?string $expectedLoadDate,
        ?string $actualLoadDate,
        ?string $expectedUnloadDate,
        ?string $actualUnloadDate,
        ?string $checkOutDateFrom,
        ?string $checkOutDateTo,
        ?string $expectedLoadDateFrom,
        ?string $expectedLoadDateTo,
        ?string $expectedUnloadDateFrom,
        ?string $expectedUnloadDateTo,
        ?string $loadDateFrom,
        ?string $loadDateTo,
        ?string $unloadDateFrom,
        ?string $unloadDateTo,
        ?array $creationUser,
        ?string $creationDate
    ) {
        $this->movementTypeId = $movementTypeId;
        $this->movementCategory = $movementCategory;
        $this->movementStatusId = $movementStatusId;
        $this->id = $id;
        $this->orderNumber = $orderNumber;
        $this->extTransport = $extTransport;
        $this->licensePlate = $licensePlate;
        $this->vin = $vin;
        $this->brandId = $brandId;
        $this->modelId = $modelId;
        $this->supplierCode = $supplierCode;
        $this->originLocationId = $originLocationId;
        $this->manualOriginLocation = $manualOriginLocation;
        $this->destinationLocationId = $destinationLocationId;
        $this->manualDestinationLocation = $manualDestinationLocation;
        $this->originBranchId = $originBranchId;
        $this->destinationBranchId = $destinationBranchId;
        $this->businessUnitId = $businessUnitId;
        $this->businessUnitArticleId = $businessUnitArticleId;
        $this->expectedLoadDate = $expectedLoadDate;
        $this->actualLoadDate = $actualLoadDate;
        $this->expectedUnloadDate = $expectedUnloadDate;
        $this->actualUnloadDate = $actualUnloadDate;
        $this->checkOutDateFrom = $checkOutDateFrom;
        $this->checkOutDateTo = $checkOutDateTo;
        $this->expectedLoadDateFrom = $expectedLoadDateFrom;
        $this->expectedLoadDateTo = $expectedLoadDateTo;
        $this->expectedUnloadDateFrom = $expectedUnloadDateFrom;
        $this->expectedUnloadDateTo = $expectedUnloadDateTo;
        $this->loadDateFrom = $loadDateFrom;
        $this->loadDateTo = $loadDateTo;
        $this->unloadDateFrom = $unloadDateFrom;
        $this->unloadDateTo = $unloadDateTo;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
    }

    /**
     * Get the value of movementTypeId
     *
     * @return int|null
     */
    public function getMovementTypeId(): ?int
    {
        return $this->movementTypeId;
    }

    /**
     * Get the value of movementCategory
     *
     * @return array|null
     */
    public function getMovementCategory(): ?array
    {
        return $this->movementCategory;
    }

    /**
     * Get the value of movementStatusId
     *
     * @return array|null
     */
    public function getMovementStatusId(): ?array
    {
        return $this->movementStatusId;
    }

    /**
     * Get the value of id
     *
     * @return array|null
     */
    public function getId(): ?array
    {
        return $this->id;
    }

    /**
     * Get the value of orderNumber
     *
     * @return array|null
     */
    public function getOrderNumber(): ?array
    {
        return $this->orderNumber;
    }

    /**
     * Get the value of extTransport
     *
     * @return bool|null
     */
    public function getExtTransport(): ?bool
    {
        return $this->extTransport;
    }

    /**
     * Get the value of licensePlate
     *
     * @return string|null
     */
    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    /**
     * Get the value of vin
     *
     * @return string|null
     */
    public function getVin(): ?string
    {
        return $this->vin;
    }

    /**
     * Get the value of brandId
     *
     * @return array|null
     */
    public function getBrandId(): ?array
    {
        return $this->brandId;
    }

    /**
     * Get the value of modelId
     *
     * @return array|null
     */
    public function getModelId(): ?array
    {
        return $this->modelId;
    }

    /**
     * Get the value of supplierCode
     *
     * @return array|null
     */
    public function getSupplierCode(): ?array
    {
        return $this->supplierCode;
    }

    /**
     * Get the value of originLocationId
     */
    public function getOriginLocationId()
    {
        return $this->originLocationId;
    }

    /**
     * Get the value of manualOriginLocation
     *
     * @return array|null
     */
    public function getManualOriginLocation(): ?array
    {
        return $this->manualOriginLocation;
    }

    /**
     * Get the value of destinationLocationId
     */
    public function getDestinationLocationId()
    {
        return $this->destinationLocationId;
    }

    /**
     * Get the value of manualDestinationLocation
     *
     * @return array|null
     */
    public function getManualDestinationLocation(): ?array
    {
        return $this->manualDestinationLocation;
    }

    /**
     * Get the value of originBranchId
     *
     * @return array|null
     */
    public function getOriginBranchId(): ?array
    {
        return $this->originBranchId;
    }

    /**
     * Get the value of destinationBranchId
     *
     * @return array|null
     */
    public function getDestinationBranchId(): ?array
    {
        return $this->destinationBranchId;
    }

    /**
     * Get the value of businessUnitId
     *
     * @return array|null
     */
    public function getBusinessUnitId(): ?array
    {
        return $this->businessUnitId;
    }

    /**
     * Get the value of businessUnitArticleId
     *
     * @return array|null
     */
    public function getBusinessUnitArticleId(): ?array
    {
        return $this->businessUnitArticleId;
    }

    /**
     * Get the value of expectedLoadDate
     *
     * @return string|null
     */
    public function getExpectedLoadDate(): ?string
    {
        return $this->expectedLoadDate;
    }

    /**
     * Get the value of actualLoadDate
     *
     * @return string|null
     */
    public function getActualLoadDate(): ?string
    {
        return $this->actualLoadDate;
    }

    /**
     * Get the value of expectedUnloadDate
     *
     * @return string|null
     */
    public function getExpectedUnloadDate(): ?string
    {
        return $this->expectedUnloadDate;
    }

    /**
     * Get the value of actualUnloadDate
     *
     * @return string|null
     */
    public function getActualUnloadDate(): ?string
    {
        return $this->actualUnloadDate;
    }

    /**
     * Get the value of checkOutDateFrom
     *
     * @return string|null
     */
    public function getCheckOutDateFrom(): ?string
    {
        return $this->checkOutDateFrom;
    }

    /**
     * Get the value of checkOutDateTo
     *
     * @return string|null
     */
    public function getCheckOutDateTo(): ?string
    {
        return $this->checkOutDateTo;
    }

    /**
     * Get the value of expectedLoadDateFrom
     *
     * @return string|null
     */
    public function getExpectedLoadDateFrom(): ?string
    {
        return $this->expectedLoadDateFrom;
    }

    /**
     * Get the value of expectedLoadDateTo
     *
     * @return string|null
     */
    public function getExpectedLoadDateTo(): ?string
    {
        return $this->expectedLoadDateTo;
    }

    /**
     * Get the value of expectedUnloadDateFrom
     *
     * @return string|null
     */
    public function getExpectedUnloadDateFrom(): ?string
    {
        return $this->expectedUnloadDateFrom;
    }

    /**
     * Get the value of expectedUnloadDateTo
     *
     * @return string|null
     */
    public function getExpectedUnloadDateTo(): ?string
    {
        return $this->expectedUnloadDateTo;
    }

    /**
     * Get the value of loadDateFrom
     *
     * @return string|null
     */
    public function getLoadDateFrom(): ?string
    {
        return $this->loadDateFrom;
    }

    /**
     * Get the value of loadDateTo
     *
     * @return string|null
     */
    public function getLoadDateTo(): ?string
    {
        return $this->loadDateTo;
    }

    /**
     * Get the value of unloadDateFrom
     *
     * @return string|null
     */
    public function getUnloadDateFrom(): ?string
    {
        return $this->unloadDateFrom;
    }

    /**
     * Get the value of unloadDateTo
     *
     * @return string|null
     */
    public function getUnloadDateTo(): ?string
    {
        return $this->unloadDateTo;
    }

    /**
     * Get the value of creationUser
     *
     * @return array|null
     */
    public function getCreationUser(): ?array
    {
        return $this->creationUser;
    }

    /**
     * Get the value of creationDate
     *
     * @return string|null
     */
    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }
}
