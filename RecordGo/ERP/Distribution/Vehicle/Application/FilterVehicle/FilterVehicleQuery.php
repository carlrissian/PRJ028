<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Application\FilterVehicle;

class FilterVehicleQuery
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
    private ?string $sort;

    /**
     * @var string|null
     */
    private ?string $order;

    /**
     * @var integer|null
     */
    private ?int $regionId;

    /**
     * @var array|null
     */
    private ?array $areaId;

    /**
     * @var array|null
     */
    private ?array $branchId;

    /**
     * @var array|null
     */
    private ?array $locationId;

    /**
     * @var integer|null
     */
    private ?int $brandId;

    /**
     * @var integer|null
     */
    private ?int $modelId;

    /**
     * @var integer|null
     */
    private ?int $trimId;

    /**
     * @var array|null
     */
    private ?array $providerId;

    /**
     * @var array|null
     */
    private ?array $purchaseMethodId;

    /**
     * @var array|null
     */
    private ?array $saleMethodId;

    /**
     * @var array|null
     */
    private ?array $carClassIdIn;

    /**
     * @var array|null
     */
    private ?array $groupIdIn;

    /**
     * @var array|null
     */
    private ?array $acrissIdIn;

    /**
     * @var array|null
     */
    private ?array $motorizationTypeIdIn;

    /**
     * @var array|null
     */
    private ?array $gearBoxIdIn;

    /**
     * @var array|null
     */
    private ?array $statusIdIn;

    /**
     * @var integer|null
     */
    private ?int $actualKmsFrom;

    /**
     * @var integer|null
     */
    private ?int $actualKmsTo;

    /**
     * @var string|null
     */
    private ?string $deliveryDateFrom;

    /**
     * @var string|null
     */
    private ?string $deliveryDateTo;

    /**
     * @var string|null
     */
    private ?string $firstRentDateFrom;

    /**
     * @var string|null
     */
    private ?string $firstRentDateTo;

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
    private ?string $byeByeDateFrom;

    /**
     * @var string|null
     */
    private ?string $byeByeDateTo;

    /**
     * @var array|null
     */
    private ?array $returnTransportIdIn;

    /**
     * @var integer|null
     */
    private ?int $transportationAssumedCostBy;

    /**
     * @var string|null
     */
    private ?string $returnDateFrom;

    /**
     * @var string|null
     */
    private ?string $returnDateTo;

    /**
     * @var string|null
     */
    private ?string $creationDateFrom;

    /**
     * @var string|null
     */
    private ?string $creationDateTo;

    /**
     * @var string|null
     */
    private ?string $registrationDateFrom;

    /**
     * @var string|null
     */
    private ?string $registrationDateTo;

    /**
     * @var string|null
     */
    private ?string $initBlockageDateFrom;

    /**
     * @var string|null
     */
    private ?string $initBlockageDateTo;

    /**
     * @var string|null
     */
    private ?string $endBlockageDateFrom;

    /**
     * @var string|null
     */
    private ?string $endBlockageDateTo;

    /**
     * @var string|null
     */
    private ?string $checkInDateFrom;

    /**
     * @var string|null
     */
    private ?string $checkInDateTo;

    /**
     * @var string|null
     */
    private ?string $checkOutDateFrom;

    /**
     * @var string|null
     */
    private ?string $checkOutDateTo;

    /**
     * @var array|null
     */
    private ?array $vehicleTypeIdIn;

    /**
     * @var array|null
     */
    private ?array $connectedIn;

    /**
     * @var array|null
     */
    private ?array $columns;

    /**
     * @var string|null
     */
    private ?string $cleanVehicle;

    /**
     * FilterVehicleQuery constructor.
     *
     * @param integer|null $limit
     * @param integer|null $offset
     * @param string|null $sort
     * @param string|null $order
     * @param integer|null $regionId
     * @param array|null $areaId
     * @param array|null $branchId
     * @param integer|null $brandId
     * @param integer|null $modelId
     * @param integer|null $trimId
     * @param array|null $providerId
     * @param array|null $purchaseMethodId
     * @param array|null $saleMethodId
     * @param array|null $carClassIdIn
     * @param array|null $groupIdIn
     * @param array|null $acrissIdIn
     * @param array|null $motorizationTypeIdIn
     * @param array|null $gearBoxIdIn
     * @param array|null $statusIdIn
     * @param int|null $actualKmsFrom
     * @param int|null $actualKmsTo
     * @param string|null $deliveryDateFrom
     * @param string|null $deliveryDateTo
     * @param string|null $firstRentDateFrom
     * @param string|null $firstRentDateTo
     * @param string|null $rentingEndDateFrom
     * @param string|null $rentingEndDateTo
     * @param string|null $byeByeDateFrom
     * @param string|null $byeByeDateTo
     * @param array|null $returnTransportIdIn
     * @param string|null $transportationAssumedCostBy
     * @param string|null $returnDateFrom
     * @param string|null $returnDateTo
     * @param string|null $creationDateFrom
     * @param string|null $creationDateTo
     * @param string|null $registrationDateFrom
     * @param string|null $registrationDateTo
     * @param string|null $initBlockageDateFrom
     * @param string|null $initBlockageDateTo
     * @param string|null $endBlockageDateFrom
     * @param string|null $endBlockageDateTo
     * @param string|null $checkInDateFrom
     * @param string|null $checkInDateTo
     * @param string|null $checkOutDateFrom
     * @param string|null $checkOutDateTo
     * @param array|null $vehicleTypeIdIn
     * @param array|null $connectedIn
     * @param array|null $columns
     *  @param string|null $cleanVehicle
     */
    public function __construct(
        ?int $limit,
        ?int $offset,
        ?string $sort,
        ?string $order,
        ?int $regionId,
        ?array $areaId,
        ?array $branchId,
        ?array $locationId,
        ?int $brandId,
        ?int $modelId,
        ?int $trimId,
        ?array $providerId,
        ?array $purchaseMethodId,
        ?array $saleMethodId,
        ?array $carClassIdIn,
        ?array $groupIdIn,
        ?array $acrissIdIn,
        ?array $motorizationTypeIdIn,
        ?array $gearBoxIdIn,
        ?array $statusIdIn,
        ?int $actualKmsFrom,
        ?int $actualKmsTo,
        ?string $deliveryDateFrom,
        ?string $deliveryDateTo,
        ?string $firstRentDateFrom,
        ?string $firstRentDateTo,
        ?string $rentingEndDateFrom,
        ?string $rentingEndDateTo,
        ?string $byeByeDateFrom,
        ?string $byeByeDateTo,
        ?array $returnTransportIdIn,
        ?string $transportationAssumedCostBy,
        ?string $returnDateFrom,
        ?string $returnDateTo,
        ?string $creationDateFrom,
        ?string $creationDateTo,
        ?string $registrationDateFrom,
        ?string $registrationDateTo,
        ?string $initBlockageDateFrom,
        ?string $initBlockageDateTo,
        ?string $endBlockageDateFrom,
        ?string $endBlockageDateTo,
        ?string $checkInDateFrom,
        ?string $checkInDateTo,
        ?string $checkOutDateFrom,
        ?string $checkOutDateTo,
        ?array $vehicleTypeIdIn,
        ?array $connectedIn,
        ?array $columns = null,
        ?string $cleanVehicle = null
    ) {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->sort = $sort;
        $this->order = $order;
        $this->regionId = $regionId;
        $this->areaId = $areaId;
        $this->branchId = $branchId;
        $this->locationId = $locationId;
        $this->brandId = $brandId;
        $this->modelId = $modelId;
        $this->trimId = $trimId;
        $this->providerId = $providerId;
        $this->purchaseMethodId = $purchaseMethodId;
        $this->saleMethodId = $saleMethodId;
        $this->carClassIdIn = $carClassIdIn;
        $this->groupIdIn = $groupIdIn;
        $this->acrissIdIn = $acrissIdIn;
        $this->motorizationTypeIdIn = $motorizationTypeIdIn;
        $this->gearBoxIdIn = $gearBoxIdIn;
        $this->statusIdIn = $statusIdIn;
        $this->actualKmsFrom = $actualKmsFrom;
        $this->actualKmsTo = $actualKmsTo;
        $this->deliveryDateFrom = $deliveryDateFrom;
        $this->deliveryDateTo = $deliveryDateTo;
        $this->firstRentDateFrom = $firstRentDateFrom;
        $this->firstRentDateTo = $firstRentDateTo;
        $this->rentingEndDateFrom = $rentingEndDateFrom;
        $this->rentingEndDateTo = $rentingEndDateTo;
        $this->byeByeDateFrom = $byeByeDateFrom;
        $this->byeByeDateTo = $byeByeDateTo;
        $this->returnTransportIdIn = $returnTransportIdIn;
        $this->transportationAssumedCostBy = $transportationAssumedCostBy;
        $this->returnDateFrom = $returnDateFrom;
        $this->returnDateTo = $returnDateTo;
        $this->creationDateFrom = $creationDateFrom;
        $this->creationDateTo = $creationDateTo;
        $this->registrationDateFrom = $registrationDateFrom;
        $this->registrationDateTo = $registrationDateTo;
        $this->initBlockageDateFrom = $initBlockageDateFrom;
        $this->initBlockageDateTo = $initBlockageDateTo;
        $this->endBlockageDateFrom = $endBlockageDateFrom;
        $this->endBlockageDateTo = $endBlockageDateTo;
        $this->checkInDateFrom = $checkInDateFrom;
        $this->checkInDateTo = $checkInDateTo;
        $this->checkOutDateFrom = $checkOutDateFrom;
        $this->checkOutDateTo = $checkOutDateTo;
        $this->vehicleTypeIdIn = $vehicleTypeIdIn;
        $this->connectedIn = $connectedIn;
        $this->columns = $columns;
        $this->cleanVehicle = $cleanVehicle;
    }

    /**
     * @return string|null
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * @return integer|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return integer|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return integer|null
     */
    public function getRegionId(): ?int
    {
        return $this->regionId;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return array|null
     */
    public function getAreaId(): ?array
    {
        return $this->areaId;
    }

    /**
     * @return array|null
     */
    public function getBranchId(): ?array
    {
        return $this->branchId;
    }

    /**
     * @return array|null
     */
    public function getLocationId(): ?array
    {
        return $this->locationId;
    }

    /**
     * @return integer|null
     */
    public function getBrandId(): ?int
    {
        return $this->brandId;
    }

    /**
     * @return integer|null
     */
    public function getModelId(): ?int
    {
        return $this->modelId;
    }

    /**
     * @return integer|null
     */
    public function getTrimId(): ?int
    {
        return $this->trimId;
    }

    /**
     * @return array|null
     */
    public function getProviderId(): ?array
    {
        return $this->providerId;
    }

    /**
     * @return array|null
     */
    public function getPurchaseMethodId(): ?array
    {
        return $this->purchaseMethodId;
    }

    /**
     * @return array|null
     */
    public function getSaleMethodId(): ?array
    {
        return $this->saleMethodId;
    }

    /**
     * @return array|null
     */
    public function getCarClassIdIn(): ?array
    {
        return $this->carClassIdIn;
    }

    /**
     * @return array|null
     */
    public function getGroupIdIn(): ?array
    {
        return $this->groupIdIn;
    }

    /**
     * @return array|null
     */
    public function getAcrissIdIn(): ?array
    {
        return $this->acrissIdIn;
    }

    /**
     * @return array|null
     */
    public function getMotorizationTypeIdIn(): ?array
    {
        return $this->motorizationTypeIdIn;
    }

    /**
     * @return array|null
     */
    public function getGearBoxIdIn(): ?array
    {
        return $this->gearBoxIdIn;
    }

    /**
     * @return array|null
     */
    public function getStatusIdIn(): ?array
    {
        return $this->statusIdIn;
    }

    /**
     * @return integer|null
     */
    public function getActualKmsFrom(): ?int
    {
        return $this->actualKmsFrom;
    }

    /**
     * @return integer|null
     */
    public function getActualKmsTo(): ?int
    {
        return $this->actualKmsTo;
    }

    /**
     * @return string|null
     */
    public function getDeliveryDateFrom(): ?string
    {
        return $this->deliveryDateFrom;
    }

    /**
     * @return string|null
     */
    public function getDeliveryDateTo(): ?string
    {
        return $this->deliveryDateTo;
    }

    /**
     * @return string|null
     */
    public function getFirstRentDateFrom(): ?string
    {
        return $this->firstRentDateFrom;
    }

    /**
     * @return string|null
     */
    public function getFirstRentDateTo(): ?string
    {
        return $this->firstRentDateTo;
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
    public function getByeByeDateFrom(): ?string
    {
        return $this->byeByeDateFrom;
    }

    /**
     * @return string|null
     */
    public function getByeByeDateTo(): ?string
    {
        return $this->byeByeDateTo;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return array|null
     */
    public function getReturnTransportIdIn(): ?array
    {
        return $this->returnTransportIdIn;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return integer|null
     */
    public function getTransportationAssumedCostBy(): ?int
    {
        return $this->transportationAssumedCostBy;
    }

    /**
     * @return string|null
     */
    public function getReturnDateFrom(): ?string
    {
        return $this->returnDateFrom;
    }

    /**
     * @return string|null
     */
    public function getReturnDateTo(): ?string
    {
        return $this->returnDateTo;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return string|null
     */
    public function getCreationDateFrom(): ?string
    {
        return $this->creationDateFrom;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return string|null
     */
    public function getCreationDateTo(): ?string
    {
        return $this->creationDateTo;
    }

    /**
     * @return string|null
     */
    public function getRegistrationDateFrom(): ?string
    {
        return $this->registrationDateFrom;
    }

    /**
     * @return string|null
     */
    public function getRegistrationDateTo(): ?string
    {
        return $this->registrationDateTo;
    }

    /**
     * @return string|null
     */
    public function getInitBlockageDateFrom(): ?string
    {
        return $this->initBlockageDateFrom;
    }

    /**
     * @return string|null
     */
    public function getInitBlockageDateTo(): ?string
    {
        return $this->initBlockageDateTo;
    }

    /**
     * @return string|null
     */
    public function getEndBlockageDateFrom(): ?string
    {
        return $this->endBlockageDateFrom;
    }

    /**
     * @return string|null
     */
    public function getEndBlockageDateTo(): ?string
    {
        return $this->endBlockageDateTo;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return string|null
     */
    public function getCheckInDateFrom(): ?string
    {
        return $this->checkInDateFrom;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return string|null
     */
    public function getCheckInDateTo(): ?string
    {
        return $this->checkInDateTo;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return string|null
     */
    public function getCheckOutDateFrom(): ?string
    {
        return $this->checkOutDateFrom;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return string|null
     */
    public function getCheckOutDateTo(): ?string
    {
        return $this->checkOutDateTo;
    }

    /**
     * @return array|null
     */
    public function getVehicleTypeIdIn(): ?array
    {
        return $this->vehicleTypeIdIn;
    }

    /**
     * @deprecated NO MVP
     * 
     * @return array|null
     */
    public function getConnectedIn(): ?array
    {
        return $this->connectedIn;
    }

    /**
     * @return array|null
     */
    public function getColumns(): ?array
    {
        return $this->columns;
    }

    /**
     * @return string|null
     */
    public function getCleanVehicle(): ?string
    {
        return $this->cleanVehicle;
    }
}
