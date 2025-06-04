<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\UpdateMovement;

class UpdateMovementCommand
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int|null
     */
    private ?int $movementTypeId;

    /**
     * @var int|null
     */
    private ?int $movementCategoryId;

    /**
     * @var bool|null
     */
    private ?bool $extTransport;

    /**
     * @var int|null
     */
    private ?int $vehicleId;

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
     * @var int|null
     */
    private ?int $departmentId;

    /**
     * @var int|null
     */
    private ?int $providerId;

    /**
     * @var int|null
     */
    private ?int $driverId;

    /**
     * @var string|null
     */
    private ?string $businessUnitId;

    /**
     * @var string|null
     */
    private ?string $businessUnitArticleId;

    /**
     * @var int|null
     */
    private ?int $transportMethodId;

    /**
     * @var int|null
     */
    private ?int $vehicleUnits;

    /**
     * @var float|null
     */
    private ?float $manualCost;

    /**
     * @var float|null
     */
    private ?float $automaticCost;

    /**
     * @var string|null
     */
    private ?string $notes;

    /**
     * @var int|null
     */
    private ?int $originLocationId;

    /**
     * @var string|null
     */
    private ?string $originLocationName;

    /**
     * @var int|null
     */
    private ?int $originExternalproviderId;
    /**
     * @var int|null
     */
    private ?int $originExternalLocationId;

    /**
     * @var int|null
     */
    private ?int $manualOriginLocationCountryId;

    /**
     * @var int|null
     */
    private ?int $manualOriginLocationProvinceId;

    /**
     * @var string|null
     */
    private ?string $manualOriginLocationNotes;

    /**
     * @var int|null
     */
    private ?int $destinationLocationId;

    /**
     * @var int|null
     */
    private ?int $destinationExternalproviderId;

    /**
     * @var int|null
     */
    private ?int $destinationExternalLocationId;

    /**
     * @var int|null
     */
    private ?int $manualDestinationLocationCountryId;

    /**
     * @var int|null
     */
    private ?int $manualDestinationLocationProvinceId;

    /**
     * @var string|null
     */
    private ?string $manualDestinationLocationNotes;

    /**
     * @var array|null
     */
    private ?array $vehicleType;

    /**
     * @var array|null
     */
    private ?array $brand;

    /**
     * @var array|null
     */
    private ?array $model;

    /**
     * @var array|null
     */
    private ?array $carGroup;

    /**
     * @var int|null
     */
    private ?int $kilometersFrom;

    /**
     * @var int|null
     */
    private ?int $kilometersTo;

    /**
     * @var string|null
     */
    private ?string $rentingEndDateFrom;

    /**
     * @var string|null
     */
    private ?string $rentingEndDateTo;

    /**
     * @var string|null
     */
    private ?string $checkInDateFrom;

    /**
     * @var array|null
     */
    private ?array $saleMethod;

    /**
     * @var array|null
     */
    private ?array $vehicleStatus;

    /**
     * @var bool|null
     */
    private ?bool $connectedVehicle;

    /**
     * UpdateMovementCommand constructor.
     *
     * @param int $id
     * @param integer|null $movementTypeId
     * @param integer|null $movementCategoryId
     * @param boolean|null $extTransport
     * @param integer|null $vehicleId
     * @param string|null $expectedLoadDate
     * @param string|null $actualLoadDate
     * @param string|null $expectedUnloadDate
     * @param string|null $actualUnloadDate
     * @param integer|null $departmentId
     * @param integer|null $providerId
     * @param integer|null $driverId
     * @param string|null $businessUnitId
     * @param string|null $businessUnitArticleId
     * @param integer|null $transportMethodId
     * @param integer|null $vehicleUnits
     * @param float|null $manualCost
     * @param float|null $automaticCost
     * @param string|null $notes
     * @param integer|null $originLocationId
     * @param string|null $originLocationName
     * @param integer|null $originExternalproviderId
     * @param integer|null $originExternalLocationId
     * @param integer|null $manualOriginLocationCountryId
     * @param integer|null $manualOriginLocationProvinceId
     * @param string|null $manualOriginLocationNotes
     * @param integer|null $destinationLocationId
     * @param integer|null $destinationExternalproviderId
     * @param integer|null $destinationExternalLocationId
     * @param integer|null $manualDestinationLocationCountryId
     * @param integer|null $manualDestinationLocationProvinceId
     * @param string|null $manualDestinationLocationNotes
     * @param array|null $vehicleType
     * @param array|null $brand
     * @param array|null $model
     * @param array|null $carGroup
     * @param integer|null $kilometersFrom
     * @param integer|null $kilometersTo
     * @param string|null $rentingEndDateFrom
     * @param string|null $rentingEndDateTo
     * @param string|null $checkInDateFrom
     * @param array|null $saleMethod
     * @param array|null $vehicleStatus
     * @param boolean|null $connectedVehicle
     */
    public function __construct(
        int $id,
        ?int $movementTypeId,
        ?int $movementCategoryId,
        ?bool $extTransport,
        ?int $vehicleId,
        ?string $expectedLoadDate,
        ?string $actualLoadDate,
        ?string $expectedUnloadDate,
        ?string $actualUnloadDate,
        ?int $departmentId,
        ?int $providerId,
        ?int $driverId,
        ?string $businessUnitId,
        ?string $businessUnitArticleId,
        ?int $transportMethodId,
        ?int $vehicleUnits,
        ?float $manualCost,
        ?float $automaticCost,
        ?string $notes,
        ?int $originLocationId,
        ?string $originLocationName,
        ?int $originExternalproviderId,
        ?int $originExternalLocationId,
        ?int $manualOriginLocationCountryId,
        ?int $manualOriginLocationProvinceId,
        ?string $manualOriginLocationNotes,
        ?int $destinationLocationId,
        ?int $destinationExternalproviderId,
        ?int $destinationExternalLocationId,
        ?int $manualDestinationLocationCountryId,
        ?int $manualDestinationLocationProvinceId,
        ?string $manualDestinationLocationNotes,
        ?array $vehicleType,
        ?array $brand,
        ?array $model,
        ?array $carGroup,
        ?int $kilometersFrom,
        ?int $kilometersTo,
        ?string $rentingEndDateFrom,
        ?string $rentingEndDateTo,
        ?string $checkInDateFrom,
        ?array $saleMethod,
        ?array $vehicleStatus,
        ?bool $connectedVehicle
    ) {
        $this->id = $id;
        $this->movementTypeId = $movementTypeId;
        $this->movementCategoryId = $movementCategoryId;
        $this->extTransport = $extTransport;
        $this->vehicleId = $vehicleId;
        $this->expectedLoadDate = $expectedLoadDate;
        $this->actualLoadDate = $actualLoadDate;
        $this->expectedUnloadDate = $expectedUnloadDate;
        $this->actualUnloadDate = $actualUnloadDate;
        $this->departmentId = $departmentId;
        $this->providerId = $providerId;
        $this->driverId = $driverId;
        $this->businessUnitId = $businessUnitId;
        $this->businessUnitArticleId = $businessUnitArticleId;
        $this->transportMethodId = $transportMethodId;
        $this->vehicleUnits = $vehicleUnits;
        $this->manualCost = $manualCost;
        $this->automaticCost = $automaticCost;
        $this->notes = $notes;
        $this->originLocationId = $originLocationId;
        $this->originLocationName = $originLocationName;
        $this->destinationExternalproviderId = $destinationExternalproviderId;
        $this->destinationExternalLocationId = $destinationExternalLocationId;
        $this->manualOriginLocationCountryId = $manualOriginLocationCountryId;
        $this->manualOriginLocationProvinceId = $manualOriginLocationProvinceId;
        $this->manualOriginLocationNotes = $manualOriginLocationNotes;
        $this->destinationLocationId = $destinationLocationId;
        $this->originExternalproviderId = $originExternalproviderId;
        $this->originExternalLocationId = $originExternalLocationId;
        $this->manualDestinationLocationCountryId = $manualDestinationLocationCountryId;
        $this->manualDestinationLocationProvinceId = $manualDestinationLocationProvinceId;
        $this->manualDestinationLocationNotes = $manualDestinationLocationNotes;
        $this->vehicleType = $vehicleType;
        $this->brand = $brand;
        $this->model = $model;
        $this->carGroup = $carGroup;
        $this->kilometersFrom = $kilometersFrom;
        $this->kilometersTo = $kilometersTo;
        $this->rentingEndDateFrom = $rentingEndDateFrom;
        $this->rentingEndDateTo = $rentingEndDateTo;
        $this->checkInDateFrom = $checkInDateFrom;
        $this->saleMethod = $saleMethod;
        $this->vehicleStatus = $vehicleStatus;
        $this->connectedVehicle = $connectedVehicle;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getMovementTypeId(): ?int
    {
        return $this->movementTypeId;
    }

    /**
     * @return int|null
     */
    public function getMovementCategoryId(): ?int
    {
        return $this->movementCategoryId;
    }

    /**
     * @return bool|null
     */
    public function getExtTransport(): ?bool
    {
        return $this->extTransport;
    }

    /**
     * @return int|null
     */
    public function getVehicleId(): ?int
    {
        return $this->vehicleId;
    }

    /**
     * @return string|null
     */
    public function getExpectedLoadDate(): ?string
    {
        return $this->expectedLoadDate;
    }

    /**
     * @return string|null
     */
    public function getActualLoadDate(): ?string
    {
        return $this->actualLoadDate;
    }

    /**
     * @return string|null
     */
    public function getExpectedUnloadDate(): ?string
    {
        return $this->expectedUnloadDate;
    }

    /**
     * @return string|null
     */
    public function getActualUnloadDate(): ?string
    {
        return $this->actualUnloadDate;
    }

    /**
     * @return int|null
     */
    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    /**
     * @return int|null
     */
    public function getProviderId(): ?int
    {
        return $this->providerId;
    }

    /**
     * @return int|null
     */
    public function getDriverId(): ?int
    {
        return $this->driverId;
    }

    /**
     * @return string|null
     */
    public function getBusinessUnitId(): ?string
    {
        return $this->businessUnitId;
    }

    /**
     * @return string|null
     */
    public function getBusinessUnitArticleId(): ?string
    {
        return $this->businessUnitArticleId;
    }

    /**
     * @return int|null
     */
    public function getTransportMethodId(): ?int
    {
        return $this->transportMethodId;
    }

    /**
     * @return int|null
     */
    public function getVehicleUnits(): ?int
    {
        return $this->vehicleUnits;
    }

    /**
     * @return float|null
     */
    public function getManualCost(): ?float
    {
        return $this->manualCost;
    }

    /**
     * @return float|null
     */
    public function getAutomaticCost(): ?float
    {
        return $this->automaticCost;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @return int|null
     */
    public function getOriginLocationId(): ?int
    {
        return $this->originLocationId;
    }

    /**
     * @return string|null
     */
    public function getOriginLocationName(): ?string
    {
        return $this->originLocationName;
    }

    /**
     * @return int|null
     */
    public function getOriginExternalproviderId(): ?int
    {
        return $this->originExternalproviderId;
    }

    /**
     * @return int|null
     */
    public function getOriginExternalLocationId(): ?int
    {
        return $this->originExternalLocationId;
    }

    /**
     * @return int|null
     */
    public function getManualOriginLocationCountryId(): ?int
    {
        return $this->manualOriginLocationCountryId;
    }

    /**
     * @return int|null
     */
    public function getManualOriginLocationProvinceId(): ?int
    {
        return $this->manualOriginLocationProvinceId;
    }

    /**
     * @return string|null
     */
    public function getManualOriginLocationNotes(): ?string
    {
        return $this->manualOriginLocationNotes;
    }

    /**
     * @return int|null
     */
    public function getDestinationLocationId(): ?int
    {
        return $this->destinationLocationId;
    }

    /**
     * @return int|null
     */
    public function getDestinationExternalproviderId(): ?int
    {
        return $this->destinationExternalproviderId;
    }

    /**
     * @return int|null
     */
    public function getDestinationExternalLocationId(): ?int
    {
        return $this->destinationExternalLocationId;
    }

    /**
     * @return int|null
     */
    public function getManualDestinationLocationCountryId(): ?int
    {
        return $this->manualDestinationLocationCountryId;
    }

    /**
     * @return int|null
     */
    public function getManualDestinationLocationProvinceId(): ?int
    {
        return $this->manualDestinationLocationProvinceId;
    }

    /**
     * @return string|null
     */
    public function getManualDestinationLocationNotes(): ?string
    {
        return $this->manualDestinationLocationNotes;
    }

    /**
     * @return array|null
     */
    public function getVehicleType(): ?array
    {
        return $this->vehicleType;
    }

    /**
     * @return array|null
     */
    public function getBrand(): ?array
    {
        return $this->brand;
    }

    /**
     * @return array|null
     */
    public function getModel(): ?array
    {
        return $this->model;
    }

    /**
     * @return array|null
     */
    public function getCarGroup(): ?array
    {
        return $this->carGroup;
    }

    /**
     * @return int|null
     */
    public function getKilometersFrom(): ?int
    {
        return $this->kilometersFrom;
    }

    /**
     * @return int|null
     */
    public function getKilometersTo(): ?int
    {
        return $this->kilometersTo;
    }

    /**
     * @return string|null
     */
    public function getRentingEndDateFrom(): ?string
    {
        return $this->rentingEndDateFrom;
    }

    /**
     * @return string|null
     */
    public function getRentingEndDateTo(): ?string
    {
        return $this->rentingEndDateTo;
    }

    /**
     * @return string|null
     */
    public function getCheckInDateFrom(): ?string
    {
        return $this->checkInDateFrom;
    }

    /**
     * @return array|null
     */
    public function getSaleMethod(): ?array
    {
        return $this->saleMethod;
    }

    /**
     * @return array|null
     */
    public function getVehicleStatus(): ?array
    {
        return $this->vehicleStatus;
    }

    /**
     * @return bool|null
     */
    public function getConnectedVehicle(): ?bool
    {
        return $this->connectedVehicle;
    }
}
