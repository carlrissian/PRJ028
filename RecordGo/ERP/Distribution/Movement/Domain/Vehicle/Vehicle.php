<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain\Vehicle;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;

/**
 * Class Vehicle
 * @package Distribution\Vehicle\Domain
 */
class Vehicle
{
    /**
     * @var integer|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $licensePlate;

    /**
     * @var string|null
     */
    private ?string $vin;

    /**
     * @var VehicleStatus|null
     */
    private ?VehicleStatus $status;

    /**
     * @var VehicleType|null
     */
    private ?VehicleType $type;

    /**
     * @var boolean|null
     */
    private ?bool $connected;

    /**
     * @var Brand|null
     */
    private ?Brand $brand;

    /**
     * @var Model|null
     */
    private ?Model $model;

    /**
     * @var CarGroup|null
     */
    private ?CarGroup $carGroup;

    /**
     * @var int|null
     */
    private ?int $actualKms;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $rentingEndDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $dropoffDate;

    /**
     * @var SaleMethod|null
     */
    private ?SaleMethod $saleMethod;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $initBlockDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $endBlockDate;

    /**
     * @var float|null
     */
    private ?float $tankCapacity;

    /**
     * @var float|null
     */
    private ?float $batteryCapacity;

    /**
     * @var CarClass|null
     */
    private ?CarClass $carClass;

    /**
     * @var Acriss|null
     */
    private ?Acriss $acriss;

    /**
     * @var Country|null
     */
    private ?Country $country;

    /**
     * @var Region|null
     */
    private ?Region $region;

    /**
     * @var Area|null
     */
    private ?Area $area;

    /**
     * @var Branch|null
     */
    private ?Branch $branch;

    /**
     * @var Location|null
     */
    private ?Location $location;

    /**
     * @var string|null
     */
    private ?string $trimName;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $checkInDate;

    /**
     * Vehicle constructor
     *
     * @param integer|null $id
     * @param string|null $licensePlate
     * @param string|null $vin
     * @param VehicleStatus|null $status
     * @param VehicleType|null $type
     * @param boolean|null $connected
     * @param Brand|null $brand
     * @param Model|null $model
     * @param CarGroup|null $carGroup
     * @param int|null $actualKms
     * @param DateValueObject|null $rentingEndDate
     * @param DateValueObject|null $dropoffDate
     * @param SaleMethod|null $saleMethod
     * @param DateValueObject|null $initBlockDate
     * @param DateValueObject|null $endBlockDate
     * @param float|null $tankCapacity
     * @param float|null $batteryCapacity
     * @param CarClass|null $carClass
     * @param Acriss|null $acriss
     * @param Country|null $country
     * @param Region|null $region
     * @param Area|null $area
     * @param Branch|null $branch
     * @param Location|null $location
     * @param string|null $trimName
     * @param DateValueObject|null $checkInDate
     */
    public function __construct(
        ?int $id = null,
        ?string $licensePlate = null,
        ?string $vin = null,
        ?VehicleStatus $status = null,
        ?VehicleType $type = null,
        ?bool $connected = null,
        ?Brand $brand = null,
        ?Model $model = null,
        ?CarGroup $carGroup = null,
        ?int $actualKms = null,
        ?DateValueObject $rentingEndDate = null,
        ?DateValueObject $dropoffDate = null,
        ?SaleMethod $saleMethod = null,
        ?DateValueObject $initBlockDate = null,
        ?DateValueObject $endBlockDate = null,
        ?float $tankCapacity = null,
        ?float $batteryCapacity = null,
        ?CarClass $carClass = null,
        ?Acriss $acriss = null,
        ?Country $country = null,
        ?Region $region = null,
        ?Area $area = null,
        ?Branch $branch = null,
        ?Location $location = null,
        ?string $trimName = null,
        ?DateValueObject $checkInDate = null
    ) {
        $this->id = $id;
        $this->licensePlate = $licensePlate;
        $this->vin = $vin;
        $this->status = $status;
        $this->type = $type;
        $this->connected = $connected;
        $this->brand = $brand;
        $this->model = $model;
        $this->carGroup = $carGroup;
        $this->actualKms = $actualKms;
        $this->rentingEndDate = $rentingEndDate;
        $this->dropoffDate = $dropoffDate;
        $this->saleMethod = $saleMethod;
        $this->initBlockDate = $initBlockDate;
        $this->endBlockDate = $endBlockDate;
        $this->tankCapacity = $tankCapacity;
        $this->batteryCapacity = $batteryCapacity;
        $this->carClass = $carClass;
        $this->acriss = $acriss;
        $this->country = $country;
        $this->region = $region;
        $this->area = $area;
        $this->branch = $branch;
        $this->location = $location;
        $this->trimName = $trimName;
        $this->checkInDate = $checkInDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function getStatus(): ?VehicleStatus
    {
        return $this->status;
    }

    public function getType(): ?VehicleType
    {
        return $this->type;
    }

    public function isConnected(): ?bool
    {
        return $this->connected;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function getCarGroup(): ?CarGroup
    {
        return $this->carGroup;
    }

    public function getActualKms(): ?int
    {
        return $this->actualKms;
    }

    public function getRentingEndDate(): ?DateValueObject
    {
        return $this->rentingEndDate;
    }

    public function getDropoffDate(): ?DateValueObject
    {
        return $this->dropoffDate;
    }

    public function getSaleMethod(): ?SaleMethod
    {
        return $this->saleMethod;
    }

    public function getInitBlockDate(): ?DateValueObject
    {
        return $this->initBlockDate;
    }

    public function getEndBlockDate(): ?DateValueObject
    {
        return $this->endBlockDate;
    }

    public function getTankCapacity(): ?float
    {
        return $this->tankCapacity;
    }

    public function getBatteryCapacity(): ?float
    {
        return $this->batteryCapacity;
    }

    public function getCarClass(): ?CarClass
    {
        return $this->carClass;
    }

    public function getAcriss(): ?Acriss
    {
        return $this->acriss;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function getTrimName(): ?string
    {
        return $this->trimName;
    }

    public function getCheckInDate(): ?DateValueObject
    {
        return $this->checkInDate;
    }


    /**
     * @param array|null $vehicleArray
     * @return Vehicle
     */
    public static function createFromArray(?array $vehicleArray): Vehicle
    {
        return new self(
            intval($vehicleArray['ID']),
            $vehicleArray['LICENSEPLATE'] ?? null,
            $vehicleArray['VIN'] ?? null,
            isset($vehicleArray['VEHICLESTATUS']) ? VehicleStatus::createFromArray($vehicleArray['VEHICLESTATUS']) : null,
            isset($vehicleArray['VEHICLETYPE']) ? VehicleType::createFromArray($vehicleArray['VEHICLETYPE']) : null,
            isset($vehicleArray['CONNECTEDVEHICLE']) && !empty($vehicleArray['CONNECTEDVEHICLE']) ? $vehicleArray['CONNECTEDVEHICLE'] == 1 : null,
            isset($vehicleArray['BRAND']) ? Brand::createFromArray($vehicleArray['BRAND']) : null,
            isset($vehicleArray['MODEL']) ? Model::createFromArray($vehicleArray['MODEL']) : null,
            isset($vehicleArray['CARGROUP']) ? CarGroup::createFromArray($vehicleArray['CARGROUP']) : null,
            isset($vehicleArray['ACTUALKMS']) ? intval($vehicleArray['ACTUALKMS']) : null,
            isset($vehicleArray['RENTINGENDDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RENTINGENDDATE'])) : null,
            isset($vehicleArray['DROPOFFDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['DROPOFFDATE'])) : null,
            isset($vehicleArray['RESALECODE']) ? SaleMethod::createFromArray($vehicleArray['RESALECODE']) : null,
            isset($vehicleArray['INITBLOCKDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['INITBLOCKDATE'])) : null,
            isset($vehicleArray['ENDBLOCKDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['ENDBLOCKDATE'])) : null,
            isset($vehicleArray['TANKCAPACITY']) ? floatval($vehicleArray['TANKCAPACITY'])  : null,
            isset($vehicleArray['BATERYCAPACITY'])  ? floatval($vehicleArray['BATERYCAPACITY']) : null,
            isset($vehicleArray['CARCLASS']) ? CarClass::createFromArray($vehicleArray['CARCLASS']) : null,
            isset($vehicleArray['ACRISS']) ? Acriss::createFromArray($vehicleArray['ACRISS']) : null,
            isset($vehicleArray['COUNTRY']) ? Country::createFromArray($vehicleArray['COUNTRY']) : null,
            isset($vehicleArray['REGION']) ? Region::createFromArray($vehicleArray['REGION']) : null,
            isset($vehicleArray['AREA']) ? Area::createFromArray($vehicleArray['AREA']) : null,
            isset($vehicleArray['BRANCH']) ? Branch::createFromArray($vehicleArray['BRANCH']) : null,
            isset($vehicleArray['LOCATION']) ? Location::createFromArray($vehicleArray['LOCATION']) : null,
            $vehicleArray['TRIMNAME'] ?? null,
            isset($vehicleArray['RADROPOFFDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RADROPOFFDATE'])) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
