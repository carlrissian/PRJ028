<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterVehicleToAssign;

class FilterVehicleToAssignQuery
{
    /**
     * @var int|null
     */
    private ?int $limit;

    /**
     * @var int|null
     */
    private ?int $offset;

    /**
     * @var string|null
     */
    private ?string $order;

    /**
     * @var string|null
     */
    private ?string $sort;

    /**
     * @var int|null
     */
    private ?int $movementId;

    /**
     * @var int|null
     */
    private ?int $movementTypeId;

    /**
     * @var int|null
     */
    private ?int $locationId;

    /**
     * @var array|null
     */
    private ?array $vehicleTypeId;

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
    private ?array $carGroupId;

    /**
     * @var float|null
     */
    private ?float $kilometerFrom;

    /**
     * @var float|null
     */
    private ?float $kilometerTo;

    /**
     * @var string|null
     */
    private ?string $rentingEndDateFrom;

    /**
     * @var string|null
     */
    private ?string $rentingEndDateTo;

    /**
     * @var array|null
     */
    private ?array $resaleCode;

    /**
     * @var string|null
     */
    private ?string $checkInDateFrom;

    /**
     * @var array|null
     */
    private ?array $vehicleStatus;

    /**
     * @var int|null
     */
    private ?int $checkInLocation;

    /**
     * @var bool|null
     */
    private ?bool $connectedVehicle;

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $order
     * @param string|null $sort
     * @param int|null $movementId
     * @param int|null $movementTypeId
     * @param int|null $locationId
     * @param array|null $vehicleTypeId
     * @param array|null $brandId
     * @param array|null $modelId
     * @param array|null $carGroupId
     * @param float|null $kilometerFrom
     * @param float|null $kilometerTo
     * @param string|null $rentingEndDateFrom
     * @param string|null $rentingEndDateTo
     * @param array|null $resaleCode
     * @param string|null $checkInDateFrom
     * @param array|null $vehicleStatus
     * @param int|null $checkInLocation
     * @param bool|null $connectedVehicle
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $order,
        ?string $sort,
        ?int $movementId,
        ?int $movementTypeId,
        ?int $locationId,
        ?array $vehicleTypeId = null,
        ?array $brandId = null,
        ?array $modelId = null,
        ?array $carGroupId = null,
        ?float $kilometerFrom = null,
        ?float $kilometerTo = null,
        ?string $rentingEndDateFrom = null,
        ?string $rentingEndDateTo = null,
        ?array $resaleCode = null,
        ?string $checkInDateFrom = null,
        ?array $vehicleStatus = null,
        ?int $checkInLocation = null,
        ?bool $connectedVehicle = null
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $this->sort = $sort;
        $this->movementId = $movementId;
        $this->movementTypeId = $movementTypeId;
        $this->locationId = $locationId;
        $this->vehicleTypeId = $vehicleTypeId;
        $this->brandId = $brandId;
        $this->modelId = $modelId;
        $this->carGroupId = $carGroupId;
        $this->kilometerFrom = $kilometerFrom;
        $this->kilometerTo = $kilometerTo;
        $this->rentingEndDateFrom = $rentingEndDateFrom;
        $this->rentingEndDateTo = $rentingEndDateTo;
        $this->resaleCode = $resaleCode;
        $this->checkInDateFrom = $checkInDateFrom;
        $this->vehicleStatus = $vehicleStatus;
        $this->checkInLocation = $checkInLocation;
        $this->connectedVehicle = $connectedVehicle;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * @return string|null
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @return int|null
     */
    public function getMovementId(): ?int
    {
        return $this->movementId;
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
    public function getLocationId(): ?int
    {
        return $this->locationId;
    }

    /**
     * @return array|null
     */
    public function getVehicleTypeId(): ?array
    {
        return $this->vehicleTypeId;
    }

    /**
     * @return array|null
     */
    public function getBrandId(): ?array
    {
        return $this->brandId;
    }

    /**
     * @return array|null
     */
    public function getModelId(): ?array
    {
        return $this->modelId;
    }

    /**
     * @return array|null
     */
    public function getCarGroupId(): ?array
    {
        return $this->carGroupId;
    }

    /**
     * @return float|null
     */
    public function getKilometerFrom(): ?float
    {
        return $this->kilometerFrom;
    }

    /**
     * @return float|null
     */
    public function getKilometerTo(): ?float
    {
        return $this->kilometerTo;
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
     * @return array|null
     */
    public function getResaleCode(): ?array
    {
        return $this->resaleCode;
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
    public function getVehicleStatus(): ?array
    {
        return $this->vehicleStatus;
    }

    /**
     * @return int|null
     */
    public function getCheckInLocation(): ?int
    {
        return $this->checkInLocation;
    }

    /**
     * @return bool|null
     */
    public function getConnectedVehicle(): ?bool
    {
        return $this->connectedVehicle;
    }
}
