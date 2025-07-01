<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

use Shared\Utils\Utils;
use Distribution\ModelCode\Domain\ModelCode;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\DateTimeValueObject;

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
     * @var Acriss|null
     */
    private ?Acriss $acriss;

    /**
     * @var CarClass|null
     */
    private ?CarClass $carClass;

    /**
     * @var VehicleGroup|null
     */
    private ?VehicleGroup $vehicleGroup;

    /**
     * @var Brand|null
     */
    private ?Brand $brand;

    /**
     * @var Model|null
     */
    private ?Model $model;

    /**
     * @var Trim|null
     */
    private ?Trim $trim;

    /**
     * @var MotorizationType|null
     */
    private ?MotorizationType $motorizationType;

    /**
     * @var GearBox|null
     */
    private ?GearBox $gearBox;

    /**
     * @var VehicleType|null
     */
    private ?VehicleType $vehicleType;

    /**
     * @var VehicleStatus|null
     */
    private ?VehicleStatus $status;

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
     * @var PurchaseMethod|null
     */
    private ?PurchaseMethod $purchaseMethod;

    /**
     * @var PurchaseType|null
     */
    private ?PurchaseType $purchaseType;

    /**
     * @var PurchaseMethod|null
     */
    private ?PurchaseMethod $resaleCode;

    /**
     * @var CommercialGroup|null
     */
    private ?CommercialGroup $commercialGroup;

    /**
     * @var Supplier|null
     */
    private ?Supplier $supplier;

    /**
     * @var string|null
     */
    private ?string $transportInvoiceNumber;

    /**
     * @var string|null
     */
    private ?string $modelCode;

    /**
     * @var string|null
     */
    private ?string $color;

    /**
     * @var float|null
     */
    private ?float $height;

    /**
     * @var float|null
     */
    private ?float $width;

    /**
     * @var float|null
     */
    private ?float $length;

    /**
     * @var float|null
     */
    private ?float $interiorHeight;

    /**
     * @var float|null
     */
    private ?float $interiorWidth;

    /**
     * @var float|null
     */
    private ?float $interiorLength;

    /**
     * @var integer|null
     */
    private ?int $numberOfDoors;

    /**
     * @var NumberOfSeats|int|null
     */
    private $numberOfSeats;

    /**
     * @var float|null
     */
    private ?float $trunkCapacity;

    /**
     * @var float|null
     */
    private ?float $volume;

    /**
     * @var float|null
     */
    private ?float $co2;

    /**
     * @var integer|null
     */
    private ?int $actualKms;

    /**
     * @var integer|null
     */
    private ?int $maxKms;

    /**
     * @var float|null
     */
    private ?float $tankCapacity;

    /**
     * @var int|null
     */
    private ?int $tankActualOctaves;

    /**
     * @var float|null
     */
    private ?float $batteryCapacity;

    /**
     * @var float|null
     */
    private ?float $batteryActual;

    /**
     * @var boolean|null
     */
    private ?bool $connected;

    /**
     * @var VehicleImageCollection|null
     */
    private ?VehicleImageCollection $images;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $firstRegistrationDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $firstRentDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $rentingEndDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $byeByeDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $deliveryConfirmationDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $returnDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $dropOffDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $checkInDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $checkOutDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $initBlockageDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $endBlockageDate;

    /**
     * @var string|null
     */
    private ?string $blockageReason;

    /**
     * @var integer|null
     */
    private ?int $salesCustomerId;

    /**
     * @var integer|null
     */
    private ?int $movementId;

    /**
     * transporthead.sappo
     * @var integer|null
     */
    private ?int $orderNumber;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $rentalAgreementPickUpDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $rentalAgreementDropOffDate;

    /**
     * Vehicle constructor
     *
     * @param integer|null $id
     * @param string|null $licensePlate
     * @param string|null $vin
     * @param Acriss|null $acriss
     * @param CarClass|null $carClass
     * @param VehicleGroup|null $vehicleGroup
     * @param Brand|null $brand
     * @param Model|null $model
     * @param Trim|null $trim
     * @param MotorizationType|null $motorizationType
     * @param GearBox|null $gearBox
     * @param VehicleType|null $vehicleType
     * @param VehicleStatus|null $status
     * @param Country|null $country
     * @param Region|null $region
     * @param Area|null $area
     * @param Branch|null $branch
     * @param Location|null $location
     * @param PurchaseMethod|null $purchaseMethod
     * @param PurchaseType|null $purchaseType
     * @param ResaleCode|null $resaleCode
     * @param CommercialGroup|null $commercialGroup
     * @param Supplier|null $supplier
     * @param string|null $transportInvoiceNumber
     * @param ModelCode|null $modelCode
     * @param string|null $color
     * @param float|null $height
     * @param float|null $width
     * @param float|null $length
     * @param float|null $interiorHeight
     * @param float|null $interiorWidth
     * @param float|null $interiorLength
     * @param integer|null $numberOfDoors
     * @param NumberOfSeats|int|null $numberOfSeats
     * @param float|null $trunkCapacity
     * @param float|null $volume
     * @param float|null $co2
     * @param integer|null $actualKms
     * @param integer|null $maxKms
     * @param float|null $tankCapacity
     * @param int|null $tankActualOctaves
     * @param float|null $batteryCapacity
     * @param float|null $batteryActual
     * @param boolean|null $connected
     * @param VehicleImageCollection|null $images
     * @param DateTimeValueObject|null $firstRegistrationDate
     * @param DateTimeValueObject|null $firstRentDate
     * @param DateTimeValueObject|null $rentingEndDate
     * @param DateValueObject|null $byeByeDate
     * @param DateTimeValueObject|null $deliveryConfirmationDate
     * @param DateTimeValueObject|null $returnDate
     * @param DateTimeValueObject|null $dropOffDate
     * @param DateTimeValueObject|null $checkInDate
     * @param DateTimeValueObject|null $checkOutDate
     * @param DateValueObject|null $initBlockageDate
     * @param DateValueObject|null $endBlockageDate
     * @param string|null $blockageReason
     * @param integer|null $salesCustomerId
     * @param integer|null $movementId
     * @param integer|null $orderNumber
     * @param DateTimeValueObject|null $rentalAgreementPickUpDate
     * @param DateTimeValueObject|null $rentalAgreementDropOffDate
     */
    public function __construct(
        ?int $id,
        ?string $licensePlate,
        ?string $vin,
        ?Acriss $acriss,
        ?CarClass $carClass,
        ?VehicleGroup $vehicleGroup,
        ?Brand $brand,
        ?Model $model,
        ?Trim $trim,
        ?MotorizationType $motorizationType,
        ?GearBox $gearBox,
        ?VehicleType $vehicleType,
        ?VehicleStatus $status,
        ?Country $country,
        ?Region $region,
        ?Area $area,
        ?Branch $branch,
        ?Location $location,
        ?PurchaseMethod $purchaseMethod,
        ?PurchaseType $purchaseType,
        ?PurchaseMethod $resaleCode,
        ?CommercialGroup $commercialGroup,
        ?Supplier $supplier,
        ?string $transportInvoiceNumber,
        ?string $modelCode,
        ?string $color,
        ?float $height,
        ?float $width,
        ?float $length,
        ?float $interiorHeight,
        ?float $interiorWidth,
        ?float $interiorLength,
        ?int $numberOfDoors,
        $numberOfSeats,
        ?float $trunkCapacity,
        ?float $volume,
        ?float $co2,
        ?int $actualKms,
        ?int $maxKms,
        ?float $tankCapacity,
        ?int $tankActualOctaves,
        ?float $batteryCapacity,
        ?float $batteryActual,
        ?bool $connected,
        ?VehicleImageCollection $images,
        ?DateTimeValueObject $firstRegistrationDate,
        ?DateTimeValueObject $firstRentDate,
        ?DateTimeValueObject $rentingEndDate,
        ?DateValueObject $byeByeDate,
        ?DateTimeValueObject $deliveryConfirmationDate,
        ?DateTimeValueObject $returnDate,
        ?DateTimeValueObject $dropOffDate,
        ?DateTimeValueObject $checkInDate,
        ?DateTimeValueObject $checkOutDate,
        ?DateValueObject $initBlockageDate,
        ?DateValueObject $endBlockageDate,
        ?string $blockageReason,
        ?int $salesCustomerId,
        ?int $movementId,
        ?int $orderNumber,
        ?DateTimeValueObject $rentalAgreementPickUpDate,
        ?DateTimeValueObject $rentalAgreementDropOffDate
    ) {
        $this->id = $id;
        $this->licensePlate = $licensePlate;
        $this->vin = $vin;
        $this->acriss = $acriss;
        $this->carClass = $carClass;
        $this->vehicleGroup = $vehicleGroup;
        $this->brand = $brand;
        $this->model = $model;
        $this->trim = $trim;
        $this->motorizationType = $motorizationType;
        $this->gearBox = $gearBox;
        $this->vehicleType = $vehicleType;
        $this->status = $status;
        $this->country = $country;
        $this->region = $region;
        $this->area = $area;
        $this->branch = $branch;
        $this->location = $location;
        $this->purchaseMethod = $purchaseMethod;
        $this->purchaseType = $purchaseType;
        $this->resaleCode = $resaleCode;
        $this->commercialGroup = $commercialGroup;
        $this->supplier = $supplier;
        $this->transportInvoiceNumber = $transportInvoiceNumber;
        $this->modelCode = $modelCode;
        $this->color = $color;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
        $this->interiorHeight = $interiorHeight;
        $this->interiorWidth = $interiorWidth;
        $this->interiorLength = $interiorLength;
        $this->numberOfDoors = $numberOfDoors;
        $this->numberOfSeats = $numberOfSeats;
        $this->trunkCapacity = $trunkCapacity;
        $this->volume = $volume;
        $this->co2 = $co2;
        $this->actualKms = $actualKms;
        $this->maxKms = $maxKms;
        $this->tankCapacity = $tankCapacity;
        $this->tankActualOctaves = $tankActualOctaves;
        $this->batteryCapacity = $batteryCapacity;
        $this->batteryActual = $batteryActual;
        $this->connected = $connected;
        $this->images = $images;
        $this->firstRegistrationDate = $firstRegistrationDate;
        $this->firstRentDate = $firstRentDate;
        $this->rentingEndDate = $rentingEndDate;
        $this->byeByeDate = $byeByeDate;
        $this->deliveryConfirmationDate = $deliveryConfirmationDate;
        $this->returnDate = $returnDate;
        $this->dropOffDate = $dropOffDate;
        $this->checkInDate = $checkInDate;
        $this->checkOutDate = $checkOutDate;
        $this->initBlockageDate = $initBlockageDate;
        $this->endBlockageDate = $endBlockageDate;
        $this->blockageReason = $blockageReason;
        $this->salesCustomerId = $salesCustomerId;
        $this->movementId = $movementId;
        $this->orderNumber = $orderNumber;
        $this->rentalAgreementPickUpDate = $rentalAgreementPickUpDate;
        $this->rentalAgreementDropOffDate = $rentalAgreementDropOffDate;
    }

    /**
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return Acriss|null
     */
    public function getAcriss(): ?Acriss
    {
        return $this->acriss;
    }

    /**
     * @return CarClass|null
     */
    public function getCarClass(): ?CarClass
    {
        return $this->carClass;
    }

    /**
     * @return VehicleGroup|null
     */
    public function getVehicleGroup(): ?VehicleGroup
    {
        return $this->vehicleGroup;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * @return Trim|null
     */
    public function getTrim(): ?Trim
    {
        return $this->trim;
    }

    /**
     * @return MotorizationType|null
     */
    public function getMotorizationType(): ?MotorizationType
    {
        return $this->motorizationType;
    }

    /**
     * @return GearBox|null
     */
    public function getGearBox(): ?GearBox
    {
        return $this->gearBox;
    }

    /**
     * @return VehicleType|null
     */
    public function getVehicleType(): ?VehicleType
    {
        return $this->vehicleType;
    }

    /**
     * @return VehicleStatus|null
     */
    public function getStatus(): ?VehicleStatus
    {
        return $this->status;
    }

    /**
     * @param VehicleStatus|null  $status
     * @return void
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return  Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @return Region|null
     */
    public function getRegion(): ?Region
    {
        return $this->region;
    }

    /**
     * @return Area|null
     */
    public function getArea(): ?Area
    {
        return $this->area;
    }

    /**
     * @return Branch|null
     */
    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location|null $location
     * @return void
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return PurchaseMethod|null
     */
    public function getPurchaseMethod(): ?PurchaseMethod
    {
        return $this->purchaseMethod;
    }

    /**
     * @return PurchaseType|null
     */
    public function getPurchaseType(): ?PurchaseType
    {
        return $this->purchaseType;
    }

    /**
     * @return PurchaseMethod|null
     */
    public function getSaleMethod(): ?PurchaseMethod
    {
        return $this->resaleCode;
    }

    /**
     * @return CommercialGroup|null
     */
    public function getCommercialGroup(): ?CommercialGroup
    {
        return $this->commercialGroup;
    }

    /**
     * @return Supplier|null
     */
    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    /**
     * @return string|null
     */
    public function getTransportInvoiceNumber(): ?string
    {
        return $this->transportInvoiceNumber;
    }

    /**
     * @return string|null
     */
    public function getModelCode(): ?string
    {
        return $this->modelCode;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @return float|null
     */
    public function getHeight(): ?float
    {
        return $this->height;
    }

    /**
     * @return float|null
     */
    public function getWidth(): ?float
    {
        return $this->width;
    }

    /**
     * @return float|null
     */
    public function getLength(): ?float
    {
        return $this->length;
    }

    /**
     * @return float|null
     */
    public function getInteriorHeight(): ?float
    {
        return $this->interiorHeight;
    }

    /**
     * @return float|null
     */
    public function getInteriorWidth(): ?float
    {
        return $this->interiorWidth;
    }

    /**
     * @return float|null
     */
    public function getInteriorLength(): ?float
    {
        return $this->interiorLength;
    }

    /**
     * @return integer|null
     */
    public function getNumberOfDoors(): ?int
    {
        return $this->numberOfDoors;
    }

    /**
     * @return NumberOfSeats|int|null
     */
    public function getNumberOfSeats()
    {
        return $this->numberOfSeats;
    }

    /**
     * @return float|null
     */
    public function getTrunkCapacity(): ?float
    {
        return $this->trunkCapacity;
    }

    /**
     * @return float|null
     */
    public function getVolume(): ?float
    {
        return $this->volume;
    }

    /**
     * @return float|null
     */
    public function getCo2(): ?float
    {
        return $this->co2;
    }

    /**
     * @return integer|null
     */
    public function getActualKms(): ?int
    {
        return $this->actualKms;
    }

    /**
     * @return integer|null
     */
    public function getMaxKms(): ?int
    {
        return $this->maxKms;
    }

    /**
     * @return float|null
     */
    public function getTankCapacity(): ?float
    {
        return $this->tankCapacity;
    }

    /**
     * @return int|null
     */
    public function getTankActualOctaves(): ?int
    {
        return $this->tankActualOctaves;
    }

    /**
     * @return float|null
     */
    public function getBatteryCapacity(): ?float
    {
        return $this->batteryCapacity;
    }

    /**
     * @return float|null
     */
    public function getBatteryActual(): ?float
    {
        return $this->batteryActual;
    }

    /**
     * @return boolean|null
     */
    public function isConnected(): ?bool
    {
        return $this->connected;
    }

    /**
     * @return VehicleImageCollection|null
     */
    public function getImages(): ?VehicleImageCollection
    {
        return $this->images;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getFirstRegistrationDate(): ?DateTimeValueObject
    {
        return $this->firstRegistrationDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getFirstRentDate(): ?DateTimeValueObject
    {
        return $this->firstRentDate;
    }

    /**
     * @param DateTimeValueObject|null  $firstRentDate
     * @return void
     */
    public function setFirstRentDate($firstRentDate): void
    {
        $this->firstRentDate = $firstRentDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getRentingEndDate(): ?DateTimeValueObject
    {
        return $this->rentingEndDate;
    }

    /**
     * @param DateTimeValueObject|null  $rentingEndDate
     * @return void
     */
    public function setRentingEndDate($rentingEndDate): void
    {
        $this->rentingEndDate = $rentingEndDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getByeByeDate(): ?DateValueObject
    {
        return $this->byeByeDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getDeliveryConfirmationDate(): ?DateTimeValueObject
    {
        return $this->deliveryConfirmationDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getReturnDate(): ?DateTimeValueObject
    {
        return $this->returnDate;
    }

    /**
     * @param DateTimeValueObject|null  $returnDate
     * @return void
     */
    public function setReturnDate($returnDate): void
    {
        $this->returnDate = $returnDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getDropOffDate(): ?DateTimeValueObject
    {
        return $this->dropOffDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCheckInDate(): ?DateTimeValueObject
    {
        return $this->checkInDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCheckOutDate(): ?DateTimeValueObject
    {
        return $this->checkOutDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getInitBlockageDate(): ?DateValueObject
    {
        return $this->initBlockageDate;
    }

    /**
     * @param DateValueObject|null  $initBlockageDate
     * @return void
     */
    public function setInitBlockageDate($initBlockageDate): void
    {
        $this->initBlockageDate = $initBlockageDate;
    }

    /**
     * @return DateValueObject|null
     */
    public function getEndBlockageDate(): ?DateValueObject
    {
        return $this->endBlockageDate;
    }

    /**
     * @param DateValueObject|null  $endBlockageDate
     * @return void
     */
    public function setEndBlockageDate($endBlockageDate): void
    {
        $this->endBlockageDate = $endBlockageDate;
    }

    /**
     * @return string|null
     */
    public function getBlockageReason(): ?string
    {
        return $this->blockageReason;
    }

    /**
     * @param string|null  $blockageReason
     * @return void
     */
    public function setBlockageReason($blockageReason): void
    {
        $this->blockageReason = $blockageReason;
    }

    /**
     * @return integer|null
     */
    public function getSalesCustomerId(): ?int
    {
        return $this->salesCustomerId;
    }

    /**
     * @return integer|null
     */
    public function getMovementId(): ?int
    {
        return $this->movementId;
    }

    /**
     * @return  integer|null
     */
    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getRentalAgreementPickUpDate(): ?DateTimeValueObject
    {
        return $this->rentalAgreementPickUpDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getRentalAgreementDropOffDate(): ?DateTimeValueObject
    {
        return $this->rentalAgreementDropOffDate;
    }


    /**
     * @param array|null $vehicleArray
     * @return self
     */
    public static function createFromArray(?array $vehicleArray): self
    {
        $vehicleImageCollection = new VehicleImageCollection([]);
        if (isset($vehicleArray['Images']) && $vehicleArray['Images']) {
            foreach ($vehicleArray['Images'] as $image) {
                $vehicleImageCollection->add(VehicleImage::createFromArray($image));
            }
        }

        return new self(
            intval($vehicleArray['ID']),
            $vehicleArray['LICENSEPLATE'] ?? null,
            $vehicleArray['VIN'] ?? null,
            (isset($vehicleArray['Acriss'])) ? Acriss::createFromArray($vehicleArray['Acriss']) : null,
            (isset($vehicleArray['CarClass'])) ? CarClass::createFromArray($vehicleArray['CarClass']) : null,
            (isset($vehicleArray['CarGroup'])) ? VehicleGroup::createFromArray($vehicleArray['CarGroup']) : null,
            (isset($vehicleArray['Brand'])) ? Brand::createFromArray($vehicleArray['Brand']) : null,
            (isset($vehicleArray['Model'])) ? Model::createFromArray($vehicleArray['Model']) : null,
            (isset($vehicleArray['Trim'])) ? Trim::createFromArray($vehicleArray['Trim']) : null,
            (isset($vehicleArray['MotorizationType'])) ? MotorizationType::createFromArray($vehicleArray['MotorizationType']) : null,
            (isset($vehicleArray['GearBox'])) ? GearBox::createFromArray($vehicleArray['GearBox']) : null,
            (isset($vehicleArray['VehicleType'])) ? VehicleType::createFromArray($vehicleArray['VehicleType']) : null,
            (isset($vehicleArray['VehicleStatus'])) ? VehicleStatus::createFromArray($vehicleArray['VehicleStatus']) : null,
            (isset($vehicleArray['COUNTRY'])) ? Country::createFromArray($vehicleArray['COUNTRY']) : null,
            (isset($vehicleArray['Region'])) ? Region::createFromArray($vehicleArray['Region']) : null,
            (isset($vehicleArray['Area'])) ? Area::createFromArray($vehicleArray['Area']) : null,
            (isset($vehicleArray['Branch'])) ? Branch::createFromArray($vehicleArray['Branch']) : null,
            (isset($vehicleArray['Location'])) ? Location::createFromArray($vehicleArray['Location']) : null,
            (isset($vehicleArray['PurchaseMethod'])) ? PurchaseMethod::createFromArray($vehicleArray['PurchaseMethod']) : null,
            (isset($vehicleArray['PurchaseType'])) ? PurchaseType::createFromArray($vehicleArray['PurchaseType']) : null,
            (isset($vehicleArray['ResaleCode'])) ? PurchaseMethod::createFromArray($vehicleArray['ResaleCode']) : null,
            (isset($vehicleArray['SALESGROUP'])) ? CommercialGroup::createFromArray($vehicleArray['SALESGROUP']) : null,
            (isset($vehicleArray['Supplier'])) ? Supplier::createFromArray($vehicleArray['Supplier']) : null,
            $vehicleArray['INVOICENUMBER'] ?? null,
            $vehicleArray['MODELCODE'] ?? null,
            $vehicleArray['COLOR'] ?? null,
            (isset($vehicleArray['HEIGHT'])) ? floatval($vehicleArray['HEIGHT']) : null,
            (isset($vehicleArray['WIDTH'])) ? floatval($vehicleArray['WIDTH']) : null,
            (isset($vehicleArray['LENGTH'])) ? floatval($vehicleArray['LENGTH']) : null,
            (isset($vehicleArray['INTERIORHEIGHT'])) ? floatval($vehicleArray['INTERIORHEIGHT']) : null,
            (isset($vehicleArray['INTERIORWIDTH'])) ? floatval($vehicleArray['INTERIORWIDTH']) : null,
            (isset($vehicleArray['INTERIORLENGTH'])) ? floatval($vehicleArray['INTERIORLENGTH']) : null,
            (isset($vehicleArray['NUMOFDOORS'])) ? intval($vehicleArray['NUMOFDOORS']) : null,
            isset($vehicleArray['NUMBEROFSEATS']) ? NumberOfSeats::createFromArray($vehicleArray['NUMBEROFSEATS']) : ((isset($vehicleArray['CARSEATSVALUE'])) ? intval($vehicleArray['CARSEATSVALUE']) : null),
            (isset($vehicleArray['TRUNKCAPACITY'])) ? floatval($vehicleArray['TRUNKCAPACITY']) : null,
            (isset($vehicleArray['VOLUME'])) ? floatval($vehicleArray['VOLUME']) : null,
            (isset($vehicleArray['CO2'])) ? floatval($vehicleArray['CO2']) : null,
            (isset($vehicleArray['ACTUALKMS'])) ? intval($vehicleArray['ACTUALKMS']) : null,
            (isset($vehicleArray['MAXKMS'])) ? intval($vehicleArray['MAXKMS']) : null,
            (isset($vehicleArray['TANKCAPACITY'])) ? floatval($vehicleArray['TANKCAPACITY']) : null,
            (isset($vehicleArray['TANKACTUALOCTAVES'])) ? intval($vehicleArray['TANKACTUALOCTAVES']) : null,
            (isset($vehicleArray['BATERYCAPACITY'])) ? floatval($vehicleArray['BATERYCAPACITY']) : null,
            (isset($vehicleArray['BATERYACTUAL'])) ? floatval($vehicleArray['BATERYACTUAL']) : null,
            (isset($vehicleArray['BATERYACTUAL'])) ? boolval($vehicleArray['CONNECTEDVEHICLE']) : null,
            $vehicleImageCollection,
            (isset($vehicleArray['FIRSTREGISTRATIONDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['FIRSTREGISTRATIONDATE'])) : null,
            (isset($vehicleArray['FIRSTRENTDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['FIRSTRENTDATE'])) : null,
            (isset($vehicleArray['RENTINGENDDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RENTINGENDDATE'])) : null,
            isset($vehicleArray['BYEBYEDATE']) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['BYEBYEDATE'])) : null,
            (isset($vehicleArray['DELIVERYDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['DELIVERYDATE'])) : null,
            (isset($vehicleArray['RETURNDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RETURNDATE'])) : null,
            (isset($vehicleArray['DROPOFFDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['DROPOFFDATE'])) : null,
            (isset($vehicleArray['UNLOADDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['UNLOADDATE'])) : null,
            (isset($vehicleArray['LOADDATE'])) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['LOADDATE'])) : null,
            (isset($vehicleArray['INITBLOCKDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['INITBLOCKDATE'])) : null,
            (isset($vehicleArray['ENDBLOCKDATE'])) ? new DateValueObject(Utils::convertOdataDateToDateTime($vehicleArray['ENDBLOCKDATE'])) : null,
            $vehicleArray['MOTIVE'] ?? null,
            (isset($vehicleArray['BBCUSTOMERID'])) ? intval($vehicleArray['BBCUSTOMERID']) : null,
            (isset($vehicleArray['MOVEMENTID'])) ? intval($vehicleArray['MOVEMENTID']) : null,
            (isset($vehicleArray['SAPPO'])) ? intval($vehicleArray['SAPPO']) : null,
            isset($vehicleArray['RAPICKUPDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RAPICKUPDATE'])) : null,
            isset($vehicleArray['RADROPOFFDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RADROPOFFDATE'])) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'LICENSEPLATE' => $this->getLicensePlate(),
            'VIN' => $this->getVin(),
            // 'Acriss' => ($this->getAcriss()) ? $this->getAcriss()->toArray() : null,
            // 'CarClass' => ($this->getCarClass()) ? $this->getCarClass()->toArray() : null,
            // 'CarGroup' => ($this->getVehicleGroup()) ? $this->getVehicleGroup()->toArray() : null,
            // 'Brand' => ($this->getBrand()) ? $this->getBrand()->toArray() : null,
            // 'Model' => ($this->getModel()) ? $this->getModel()->toArray() : null,
            // 'Trim' => ($this->getTrim()) ? $this->getTrim()->toArray() : null,
            // 'MotorizationType' => ($this->getMotorizationType()) ? $this->getMotorizationType()->toArray() : null,
            // 'GearBox' => ($this->getGearBox()) ? $this->getGearBox()->toArray() : null,
            // 'VehicleType' => ($this->getVehicleType()) ? $this->getVehicleType()->toArray() : null,
            // 'VehicleStatus' => ($this->getStatus()) ? $this->getStatus()->toArray() : null,
            'STATUSID' => ($this->getStatus()) ? $this->getStatus()->getId() : null,
            // 'COUNTRY' => ($this->getCountry()) ? $this->getCountry()->toArray() : null,
            // 'Region' => ($this->getRegion()) ? $this->getRegion()->toArray() : null,
            // 'Area' => ($this->getArea()) ? $this->getArea()->toArray() : null,
            // 'Branch' => $this->getBranch() ? $this->getBranch()->toArray() : null,
            // 'Location' => ($this->getLocation()) ? $this->getLocation()->toArray() : null,
            'LOCATIONID' => ($this->getLocation()) ? $this->getLocation()->getId() : null,
            // 'PurchaseMethod' => ($this->getPurchaseMethod()) ? $this->getPurchaseMethod()->toArray() : null,
            // 'PurchaseType' => ($this->getPurchaseType()) ? $this->getPurchaseType()->toArray() : null,
            // 'ResaleCode' => ($this->getSaleMethod()) ? $this->getSaleMethod()->toArray() : null,
            // 'SALESGROUP' => ($this->getCommercialGroup()) ? $this->getCommercialGroup()->toArray() : null,
            // 'Supplier' => ($this->getSupplier()) ? $this->getSupplier()->toArray() : null,
            // 'INVOICENUMBER' => $this->getTransportInvoiceNumber(),
            // 'MODELCODE' => $this->getModelCode(),
            // 'COLOR' => $this->getColor(),
            // 'HEIGHT' => $this->getHeight(),
            // 'WIDTH' => $this->getWidth(),
            // 'LENGTH' => $this->getLength(),
            // 'INTERIORHEIGHT' => $this->getInteriorHeight(),
            // 'INTERIORWIDTH' => $this->getInteriorWidth(),
            // 'INTERIORLENGTH' => $this->getInteriorLength(),
            // 'NUMOFDOORS' => $this->getNumberOfDoors(),
            // 'VEHICLESEATSID' => $this->getNumberOfSeats()->getId(),
            // 'TRUNKCAPACITY' => $this->getTrunkCapacity(),
            // 'VOLUME' => $this->getVolume(),
            // 'CO2' => $this->getCo2(),
            // 'ACTUALKMS' => $this->getActualKms(),
            // 'MAXKMS' => $this->getMaxKms(),
            // 'TANKCAPACITY' => $this->getTankCapacity(),
            // 'TANKACTUALOCTAVES' => $this->getTankActualOctaves(),
            // 'BATERYCAPACITY' => $this->getBatteryCapacity(),
            // 'BATERYACTUAL' => $this->getBatteryActual(),
            // 'CONNECTEDVEHICLE' => $this->isConnected(),
            // 'VEHICLEIMG' => $this->getImage(),
            // 'FIRSTREGISTRATIONDATE' => ($this->getFirstRegistrationDate()) ? Utils::formatStringDateTimeToOdataDate($this->getFirstRegistrationDate()->__toString(), 'd/m/Y H:i:s') : null,
            'FIRSTRENTDATE' => ($this->getFirstRentDate()) ? Utils::formatDateToFirstMinuteDateTime($this->getFirstRentDate()->__toString(), 'd/m/Y H:i:s') : null,
            'RENTINGENDDATE' => ($this->getRentingEndDate()) ? Utils::formatDateToLastMinuteDateTime($this->getRentingEndDate()->__toString(), 'd/m/Y H:i:s') : null,
            // 'DELIVERYDATE' => ($this->getDeliveryConfirmationDate()) ? Utils::formatStringDateTimeToOdataDate($this->getDeliveryConfirmationDate()->__toString(), 'd/m/Y H:i:s') : null,
            'RETURNDATE' => ($this->getReturnDate()) ? Utils::formatDateToFirstMinuteDateTime($this->getReturnDate()->__toString(), 'd/m/Y H:i:s') : null,
            // 'UNLOADDATE' => ($this->getCheckInDate()) ? Utils::formatStringDateTimeToOdataDate($this->getCheckInDate()->__toString(), 'd/m/Y H:i:s') : null,
            // 'LOADDATE' => ($this->getCheckOutDate()) ? Utils::formatStringDateTimeToOdataDate($this->getCheckOutDate()->__toString(), 'd/m/Y H:i:s') : null,
            'INITBLOCKDATE' => ($this->getInitBlockageDate()) ? Utils::formatDateToFirstMinuteDateTime($this->getInitBlockageDate()->__toString()) : null,
            'ENDBLOCKDATE' => ($this->getEndBlockageDate()) ? Utils::formatDateToLastMinuteDateTime($this->getEndBlockageDate()->__toString()) : null,
            'MOTIVE' => $this->getBlockageReason(),
            // 'BBCUSTOMERID' => $this->getSalesCustomerId(),
            // 'MOVEMENTID' => $this->getMovementId(),
            // 'SAPPO' => $this->getOrderNumber(),
        ];
    }
}
