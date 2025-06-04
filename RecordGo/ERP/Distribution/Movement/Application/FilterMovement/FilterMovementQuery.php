<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\FilterMovement;

class FilterMovementQuery
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
    private ?array $destinationLocationId;

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
    private ?string $actualLoadDateFrom;

    /**
     * @var string|null
     */
    private ?string $actualLoadDateTo;

    /**
     * @var string|null
     */
    private ?string $actualUnloadDateFrom;

    /**
     * @var string|null
     */
    private ?string $actualUnloadDateTo;

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
     * @param integer|null $limit
     * @param integer|null $offset
     * @param string|null $order
     * @param string|null $sort
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
     * @param array|null $destinationLocationId
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
     * @param string|null $actualLoadDateFrom
     * @param string|null $actualLoadDateTo
     * @param string|null $actualUnloadDateFrom
     * @param string|null $actualUnloadDateTo
     * @param array|null $creationUser
     * @param string|null $creationDate
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $order,
        ?string $sort,
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
        ?array $destinationLocationId,
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
        ?string $actualLoadDateFrom,
        ?string $actualLoadDateTo,
        ?string $actualUnloadDateFrom,
        ?string $actualUnloadDateTo,
        ?array $creationUser,
        ?string $creationDate
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->order = $order;
        $this->sort = $sort;
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
        $this->destinationLocationId = $destinationLocationId;
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
        $this->actualLoadDateFrom = $actualLoadDateFrom;
        $this->actualLoadDateTo = $actualLoadDateTo;
        $this->actualUnloadDateFrom = $actualUnloadDateFrom;
        $this->actualUnloadDateTo = $actualUnloadDateTo;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
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
    public function getMovementTypeId(): ?int
    {
        return $this->movementTypeId;
    }

    /**
     * @return array|null
     */
    public function getMovementCategory(): ?array
    {
        return $this->movementCategory;
    }

    /**
     * @return array|null
     */
    public function getMovementStatusId(): ?array
    {
        return $this->movementStatusId;
    }

    /**
     * @return array|null
     */
    public function getId(): ?array
    {
        return $this->id;
    }

    /**
     * @return array|null
     */
    public function getOrderNumber(): ?array
    {
        return $this->orderNumber;
    }

    /**
     * @return bool|null
     */
    public function getExtTransport(): ?bool
    {
        return $this->extTransport;
    }

    /**
     * @return string|null
     */
    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    /**
     * @return string|null
     */
    public function getVin(): ?string
    {
        return $this->vin;
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
    public function getSupplierCode(): ?array
    {
        return $this->supplierCode;
    }

    /**
     * @return array|null
     */
    public function getOriginLocationId(): ?array
    {
        return $this->originLocationId;
    }

    /**
     * @return array|null
     */
    public function getDestinationLocationId(): ?array
    {
        return $this->destinationLocationId;
    }

    /**
     * @return array|null
     */
    public function getOriginBranchId(): ?array
    {
        return $this->originBranchId;
    }

    /**
     * @return array|null
     */
    public function getDestinationBranchId(): ?array
    {
        return $this->destinationBranchId;
    }

    /**
     * @return array|null
     */
    public function getBusinessUnitId(): ?array
    {
        return $this->businessUnitId;
    }

    /**
     * @return array|null
     */
    public function getBusinessUnitArticleId(): ?array
    {
        return $this->businessUnitArticleId;
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
     * @return string|null
     */
    public function getCheckOutDateFrom(): ?string
    {
        return $this->checkOutDateFrom;
    }

    /**
     * @return string|null
     */
    public function getCheckOutDateTo(): ?string
    {
        return $this->checkOutDateTo;
    }

    /**
     * @return string|null
     */
    public function getExpectedLoadDateFrom(): ?string
    {
        return $this->expectedLoadDateFrom;
    }

    /**
     * @return string|null
     */
    public function getExpectedLoadDateTo(): ?string
    {
        return $this->expectedLoadDateTo;
    }

    /**
     * @return string|null
     */
    public function getExpectedUnloadDateFrom(): ?string
    {
        return $this->expectedUnloadDateFrom;
    }

    /**
     * @return string|null
     */
    public function getExpectedUnloadDateTo(): ?string
    {
        return $this->expectedUnloadDateTo;
    }

    /**
     * @return string|null
     */
    public function getActualLoadDateFrom(): ?string
    {
        return $this->actualLoadDateFrom;
    }

    /**
     * @return string|null
     */
    public function getActualLoadDateTo(): ?string
    {
        return $this->actualLoadDateTo;
    }

    /**
     * @return string|null
     */
    public function getActualUnloadDateFrom(): ?string
    {
        return $this->actualUnloadDateFrom;
    }

    /**
     * @return string|null
     */
    public function getActualUnloadDateTo(): ?string
    {
        return $this->actualUnloadDateTo;
    }

    /**
     * @return array|null
     */
    public function getCreationUser(): ?array
    {
        return $this->creationUser;
    }

    /**
     * @return string|null
     */
    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }
}
