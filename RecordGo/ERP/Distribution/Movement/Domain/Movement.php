<?php

declare(strict_types=1);

namespace Distribution\Movement\Domain;

use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Shared\Domain\User;
use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\FloatValueObject;
use Shared\Domain\ValueObject\DateTimeValueObject;

class Movement
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $orderNumber;

    /**
     * @var MovementType|null
     */
    private ?MovementType $movementType;

    /**
     * @var MovementCategory|null
     */
    private ?MovementCategory $movementCategory;

    /**
     * @var bool|null
     */
    private ?bool $extTransport;

    /**
     * @var MovementStatus|null
     */
    private ?MovementStatus $movementStatus;

    /**
     * @var Location|null
     */
    private ?Location $originLocation;

    /**
     * @var ManualLocation|null
     */
    private ?ManualLocation $manualOriginLocation;

    /**
     * @var Location|null
     */
    private ?Location $originExternalLocation;

    /**
     * @var Supplier|null
     */
    private ?Supplier $originExternalSupplier;

    /**
     * @var Branch|null
     */
    private ?Branch $originBranch;

    /**
     * @var Location|null
     */
    private ?Location $destinationLocation;

    /**
     * @var ManualLocation|null
     */
    private ?ManualLocation $manualDestinationLocation;

    /**
     * @var Location|null
     */
    private ?Location $destinationExternalLocation;

    /**
     * @var Supplier|null
     */
    private ?Supplier $destinationExternalSupplier;

    /**
     * @var Branch|null
     */
    private ?Branch $destinationBranch;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $expectedLoadDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $actualLoadDate;

    /**
     * @var DateValueObject|null
     */
    private ?DateValueObject $expectedUnloadDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $actualUnloadDate;

    /**
     * @var Department|null
     */
    private ?Department $department;

    /**
     * @var Supplier|null
     */
    private ?Supplier $supplier;

    /**
     * @var Driver|null
     */
    private ?Driver $driver;

    /**
     * @var BusinessUnit|null
     */
    private ?BusinessUnit $businessUnit;

    /**
     * @var BusinessUnitArticle|null
     */
    private ?BusinessUnitArticle $businessUnitArticle;

    /**
     * @var FloatValueObject|null
     */
    private ?FloatValueObject $automaticCost;

    /**
     * @var FloatValueObject|null
     */
    private ?FloatValueObject $manualCost;

    /**
     * @var int|null
     */
    private ?int $vehicleUnits;

    /**
     * @var string|null
     */
    private ?string $notes;

    /**
     * @var VehicleLineCollection|null
     */
    private ?VehicleLineCollection $vehicleLineCollection;

    /**
     * @var VehicleFilterCollection|null
     */
    private ?VehicleFilterCollection $vehicleFilterCollection;

    /**
     * @var DeliveryNoteCollection|null
     */
    private ?DeliveryNoteCollection $deliveryNoteCollection;

    /**
     * @var AssignedLicensePlateUnits|null
     */
    private ?AssignedLicensePlateUnits $assignedLicensePlateUnits;

    /**
     * @var TransportMethod|null
     */
    private ?TransportMethod $transportMethod;

    /**
     * @var User|null
     */
    private ?User $creationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;

    /**
     * @var User|null
     */
    private ?User $editionUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $editionDate;

    /**
     * @var User|null
     */
    private ?User $closingUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $closingDate;

    /**
     * @var string|null
     */
    private ?string $closingNotes;

    /**
     * @var User|null
     */
    private ?User $cancellationUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $cancellationDate;

    /**
     * @var string|null
     */
    private ?string $cancellationNotes;

    /**
     * NO ELIMINAR, esta variable es exclusiva para avisar al WS que se trata de una edición de cabecera de movimiento,
     * la cual se realiza en la pantalla de editar movimiento por transportista/operaciones
     * @var bool
     */
    private bool $onlyEditHead;

    /**
     * Movement constructor.
     * 
     * @param int|null $id
     * @param string|null $orderNumber
     * @param MovementType|null $movementType
     * @param MovementCategory|null $movementCategory
     * @param bool|null $extTransport
     * @param MovementStatus|null $movementStatus
     * @param Location|null $originLocation
     * @param ManualLocation|null $manualOriginLocation
     * @param Location|null $originExternalLocation
     * @param Supplier|null $originExternalSupplier
     * @param Branch|null $originBranch
     * @param Location|null $destinationLocation
     * @param ManualLocation|null $manualDestinationLocation
     * @param Location|null $destinationExternalLocation
     * @param Supplier|null $destinationExternalSupplier
     * @param Branch|null $destinationBranch
     * @param DateValueObject|null $expectedLoadDate
     * @param DateTimeValueObject|null $actualLoadDate
     * @param DateValueObject|null $expectedUnloadDate
     * @param DateTimeValueObject|null $actualUnloadDate
     * @param Department|null $department
     * @param Supplier|null $supplier
     * @param Driver|null $driver
     * @param BusinessUnit|null $businessUnit
     * @param BusinessUnitArticle|null $businessUnitArticle
     * @param FloatValueObject|null $automaticCost
     * @param FloatValueObject|null $manualCost
     * @param int|null $vehicleUnits
     * @param string|null $notes
     * @param VehicleLineCollection|null $vehicleLineCollection
     * @param VehicleFilterCollection|null $vehicleFilterCollection
     * @param DeliveryNoteCollection|null $deliveryNoteCollection
     * @param AssignedLicensePlateUnits|null $assignedLicensePlateUnits
     * @param TransportMethod|null $transportMethod
     * @param User|null $creationUser
     * @param DateTimeValueObject|null $creationDate
     * @param User|null $editionUser
     * @param DateTimeValueObject|null $editionDate
     * @param User|null $closingUser
     * @param DateTimeValueObject|null $closingDate
     * @param string|null $closingNotes
     * @param User|null $cancellationUser
     * @param DateTimeValueObject|null $cancellationDate
     * @param string|null $cancellationNotes
     * @param bool $onlyEditHead
     */
    public function __construct(
        ?int $id,
        ?string $orderNumber = null,
        ?MovementType $movementType = null,
        ?MovementCategory $movementCategory = null,
        ?bool $extTransport = null,
        ?MovementStatus $movementStatus = null,
        ?Location $originLocation = null,
        ?ManualLocation $manualOriginLocation = null,
        ?Location $originExternalLocation = null,
        ?Supplier $originExternalSupplier = null,
        ?Branch $originBranch = null,
        ?Location $destinationLocation = null,
        ?ManualLocation $manualDestinationLocation = null,
        ?Location $destinationExternalLocation = null,
        ?Supplier $destinationExternalSupplier = null,
        ?Branch $destinationBranch = null,
        ?DateValueObject $expectedLoadDate = null,
        ?DateTimeValueObject $actualLoadDate = null,
        ?DateValueObject $expectedUnloadDate = null,
        ?DateTimeValueObject $actualUnloadDate = null,
        ?Department $department = null,
        ?Supplier $supplier = null,
        ?Driver $driver = null,
        ?BusinessUnit $businessUnit = null,
        ?BusinessUnitArticle $businessUnitArticle = null,
        ?FloatValueObject $automaticCost = null,
        ?FloatValueObject $manualCost = null,
        ?int $vehicleUnits = null,
        ?string $notes = null,
        ?VehicleLineCollection $vehicleLineCollection = null,
        ?VehicleFilterCollection $vehicleFilterCollection = null,
        ?DeliveryNoteCollection $deliveryNoteCollection = null,
        ?AssignedLicensePlateUnits $assignedLicensePlateUnits = null,
        ?TransportMethod $transportMethod = null,
        ?User $creationUser = null,
        ?DateTimeValueObject $creationDate = null,
        ?User $editionUser = null,
        ?DateTimeValueObject $editionDate = null,
        ?User $closingUser = null,
        ?DateTimeValueObject $closingDate = null,
        ?string $closingNotes = null,
        ?User $cancellationUser = null,
        ?DateTimeValueObject $cancellationDate = null,
        ?string $cancellationNotes = null,
        bool $onlyEditHead = false
    ) {
        $this->id = $id;
        $this->orderNumber = $orderNumber;
        $this->movementType = $movementType;
        $this->movementCategory = $movementCategory;
        $this->extTransport = $extTransport;
        $this->movementStatus = $movementStatus;
        $this->originLocation = $originLocation;
        $this->manualOriginLocation = $manualOriginLocation;
        $this->originExternalLocation = $originExternalLocation;
        $this->originExternalSupplier = $originExternalSupplier;
        $this->originBranch = $originBranch;
        $this->destinationLocation = $destinationLocation;
        $this->manualDestinationLocation = $manualDestinationLocation;
        $this->destinationExternalLocation = $destinationExternalLocation;
        $this->destinationExternalSupplier = $destinationExternalSupplier;
        $this->destinationBranch = $destinationBranch;
        $this->expectedLoadDate = $expectedLoadDate;
        $this->actualLoadDate = $actualLoadDate;
        $this->expectedUnloadDate = $expectedUnloadDate;
        $this->actualUnloadDate = $actualUnloadDate;
        $this->department = $department;
        $this->supplier = $supplier;
        $this->driver = $driver;
        $this->businessUnit = $businessUnit;
        $this->businessUnitArticle = $businessUnitArticle;
        $this->automaticCost = $automaticCost;
        $this->manualCost = $manualCost;
        $this->vehicleUnits = $vehicleUnits;
        $this->notes = $notes;
        $this->vehicleLineCollection = $vehicleLineCollection;
        $this->vehicleFilterCollection = $vehicleFilterCollection;
        $this->deliveryNoteCollection = $deliveryNoteCollection;
        $this->assignedLicensePlateUnits = $assignedLicensePlateUnits;
        $this->transportMethod = $transportMethod;
        $this->creationUser = $creationUser;
        $this->creationDate = $creationDate;
        $this->editionUser = $editionUser;
        $this->editionDate = $editionDate;
        $this->closingUser = $closingUser;
        $this->closingDate = $closingDate;
        $this->closingNotes = $closingNotes;
        $this->cancellationUser = $cancellationUser;
        $this->cancellationDate = $cancellationDate;
        $this->cancellationNotes = $cancellationNotes;
        $this->onlyEditHead = $onlyEditHead;
    }

    /**
     * @return int|null
     */
    final public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    /**
     * @return MovementType
     */
    final public function getMovementType(): MovementType
    {
        return $this->movementType;
    }

    /**
     * @return MovementCategory|null
     */
    final public function getMovementCategory(): ?MovementCategory
    {
        return $this->movementCategory;
    }

    /**
     * @param MovementCategory|null $movementCategory
     */
    public function setMovementCategory($movementCategory)
    {
        $this->movementCategory = $movementCategory;
    }

    /**
     * @return bool|null
     */
    final public function isExtTransport(): ?bool
    {
        return $this->extTransport;
    }

    /**
     * @param bool|null $extTransport
     */
    public function setExtTransport($extTransport)
    {
        $this->extTransport = $extTransport;
    }

    /**
     * @return MovementStatus
     */
    final public function getMovementStatus(): MovementStatus
    {
        return $this->movementStatus;
    }

    /**
     * @param MovementStatus $movementStatus
     */
    public function setStatus(MovementStatus $movementStatus)
    {
        $this->movementStatus = $movementStatus;
    }

    /**
     * @return Location|null
     */
    final public function getOriginLocation(): ?Location
    {
        return $this->originLocation;
    }


    /**
     * @param Location|null $originLocation
     */
    public function setOriginLocation($originLocation)
    {
        $this->originLocation = $originLocation;
    }

    /**
     * @return ManualLocation|null
     */
    final public function getManualOriginLocation(): ?ManualLocation
    {
        return $this->manualOriginLocation;
    }

    /**
     * @param ManualLocation|null $manualOriginLocation
     */
    public function setManualOriginLocation($manualOriginLocation)
    {
        $this->manualOriginLocation = $manualOriginLocation;
    }

    /**
     * @return Location|null
     */
    final public function getOriginExternalLocation(): ?Location
    {
        return $this->originExternalLocation;
    }

    /**
     * @param  Location|null $originExternalLocation
     */
    public function setOriginExternalLocation($originExternalLocation)
    {
        $this->originExternalLocation = $originExternalLocation;
    }

    /**
     * @return Supplier|null
     */
    final public function getOriginExternalSupplier(): ?Supplier
    {
        return $this->originExternalSupplier;
    }

    /**
     * @param  Supplier|null $originExternalSupplier
     */
    public function setOriginExternalSupplier($originExternalSupplier)
    {
        $this->originExternalSupplier = $originExternalSupplier;
    }

    /**
     * @return Branch|null
     */
    final public function getOriginBranch(): ?Branch
    {
        return $this->originBranch;
    }

    /**
     * @return Location|null
     */
    final public function getDestinationLocation(): ?Location
    {
        return $this->destinationLocation;
    }

    /**
     * @param Location|null $destinationLocation
     */
    public function setDestinationLocation($destinationLocation)
    {
        $this->destinationLocation = $destinationLocation;
    }

    /**
     * @return ManualLocation|null
     */
    final public function getManualDestinationLocation(): ?ManualLocation
    {
        return $this->manualDestinationLocation;
    }

    /**
     * @param ManualLocation|null $manualDestinationLocation
     */
    public function setManualDestinationLocation($manualDestinationLocation)
    {
        $this->manualDestinationLocation = $manualDestinationLocation;
    }

    /**
     * @return Location|null
     */
    final public function getDestinationExternalLocation(): ?Location
    {
        return $this->destinationExternalLocation;
    }

    /**
     * @param  Location|null $destinationExternalLocation
     */
    public function setDestinationExternalLocation($destinationExternalLocation)
    {
        $this->destinationExternalLocation = $destinationExternalLocation;
    }

    /**
     * @return Supplier|null
     */
    final public function getDestinationExternalSupplier(): ?Supplier
    {
        return $this->destinationExternalSupplier;
    }

    /**
     * @param  Supplier|null $destinationExternalSupplier
     */
    public function setDestinationExternalSupplier($destinationExternalSupplier)
    {
        $this->destinationExternalSupplier = $destinationExternalSupplier;
    }

    /**
     * @return Branch|null
     */
    final public function getDestinationBranch(): ?Branch
    {
        return $this->destinationBranch;
    }

    /**
     * @return DateValueObject|null
     */
    final public function getExpectedLoadDate(): ?DateValueObject
    {
        return $this->expectedLoadDate;
    }

    /**
     * @param DateValueObject|null $expectedLoadDate
     */
    public function setExpectedLoadDate($expectedLoadDate)
    {
        $this->expectedLoadDate = $expectedLoadDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getActualLoadDate(): ?DateTimeValueObject
    {
        return $this->actualLoadDate;
    }

    /**
     * @param DateTimeValueObject|null $actualLoadDate
     */
    public function setActualLoadDate($actualLoadDate)
    {
        $this->actualLoadDate = $actualLoadDate;
    }

    /**
     * @return DateValueObject|null
     */
    final public function getExpectedUnloadDate(): ?DateValueObject
    {
        return $this->expectedUnloadDate;
    }

    /**
     * @param DateValueObject|null $expectedUnloadDate
     */
    public function setExpectedUnloadDate($expectedUnloadDate)
    {
        $this->expectedUnloadDate = $expectedUnloadDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getActualUnloadDate(): ?DateTimeValueObject
    {
        return $this->actualUnloadDate;
    }

    /**
     * @param DateTimeValueObject|null $actualUnloadDate
     */
    public function setActualUnloadDate($actualUnloadDate)
    {
        $this->actualUnloadDate = $actualUnloadDate;
    }

    /**
     * @return Department|null
     */
    final public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * @return Supplier|null
     */
    final public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    /**
     * @param Supplier|null $supplier
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    /**
     * @return Driver|null
     */
    final public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    /**
     * @param Driver|null $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return BusinessUnit|null
     */
    final public function getBusinessUnit(): ?BusinessUnit
    {
        return $this->businessUnit;
    }

    /**
     * @param BusinessUnit|null $businessUnit
     */
    public function setBusinessUnit($businessUnit)
    {
        $this->businessUnit = $businessUnit;
    }

    /**
     * @return BusinessUnitArticle|null
     */
    final public function getBusinessUnitArticle(): ?BusinessUnitArticle
    {
        return $this->businessUnitArticle;
    }

    /**
     * @param BusinessUnitArticle|null $businessUnitArticle
     */
    public function setBusinessUnitArticle($businessUnitArticle)
    {
        $this->businessUnitArticle = $businessUnitArticle;
    }

    /**
     * @return FloatValueObject|null
     */
    final public function getAutomaticCost(): ?FloatValueObject
    {
        return $this->automaticCost;
    }

    /**
     * @param FloatValueObject|null $automaticCost
     */
    public function setAutomaticCost($automaticCost)
    {
        $this->automaticCost = $automaticCost;
    }

    /**
     * @return FloatValueObject|null
     */
    final public function getManualCost(): ?FloatValueObject
    {
        return $this->manualCost;
    }

    /**
     * @param FloatValueObject|null $manualCost
     */
    public function setManualCost($manualCost)
    {
        $this->manualCost = $manualCost;
    }

    /**
     * @return int|null
     */
    final public function getVehicleUnits(): ?int
    {
        return $this->vehicleUnits;
    }

    public function setVehicleUnits(?int $vehicleUnits): void
    {
        $this->vehicleUnits = $vehicleUnits;
    }

    /**
     * @return string|null
     */
    final public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return VehicleLineCollection|null
     */
    final public function getVehicleLineCollection(): ?VehicleLineCollection
    {
        return $this->vehicleLineCollection;
    }

    /**
     * @param VehicleLineCollection|null $vehicleLineCollection
     */
    public function setVehicleLineCollection($vehicleLineCollection)
    {
        $this->vehicleLineCollection = $vehicleLineCollection;
    }

    /**
     * @return VehicleFilterCollection|null
     */
    final public function getVehicleFilterCollection(): ?VehicleFilterCollection
    {
        return $this->vehicleFilterCollection;
    }

    /**
     * @param VehicleFilterCollection|null $vehicleFilterCollection
     */
    public function setVehicleFilterCollection($vehicleFilterCollection)
    {
        $this->vehicleFilterCollection = $vehicleFilterCollection;
    }

    /**
     * @return DeliveryNoteCollection|null
     */
    final public function getDeliveryNoteCollection(): ?DeliveryNoteCollection
    {
        return $this->deliveryNoteCollection;
    }

    /**
     * @param DeliveryNoteCollection|null $deliveryNoteCollection
     */
    public function setDeliveryNoteCollection($deliveryNoteCollection)
    {
        $this->deliveryNoteCollection = $deliveryNoteCollection;
    }

    /**
     * @return AssignedLicensePlateUnits|null
     */
    final public function getAssignedLicensePlateUnits(): ?AssignedLicensePlateUnits
    {
        return $this->assignedLicensePlateUnits;
    }

    /**
     * @return TransportMethod|null
     */
    final public function getTransportMethod(): ?TransportMethod
    {
        return $this->transportMethod;
    }

    /**
     * @param TransportMethod|null $transportMethod
     */
    public function setTransportMethod($transportMethod)
    {
        $this->transportMethod = $transportMethod;
    }

    /**
     * @return User|null
     */
    final public function getCreationUser(): ?User
    {
        return $this->creationUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }

    /**
     * @return User|null
     */
    final public function getEditionUser(): ?User
    {
        return $this->editionUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getEditionDate(): ?DateTimeValueObject
    {
        return $this->editionDate;
    }

    /**
     * @return User|null
     */
    final public function getClosingUser(): ?User
    {
        return $this->closingUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getClosingDate(): ?DateTimeValueObject
    {
        return $this->closingDate;
    }

    /**
     * @return string|null
     */
    final public function getClosingNotes(): ?string
    {
        return $this->closingNotes;
    }

    /**
     * @param string|null $closingNotes
     */
    public function setClosingNotes($closingNotes)
    {
        $this->closingNotes = $closingNotes;
    }

    /**
     * @return User|null
     */
    final public function getCancellationUser(): ?User
    {
        return $this->cancellationUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    final public function getCancellationDate(): ?DateTimeValueObject
    {
        return $this->cancellationDate;
    }

    /**
     * @return string|null
     */
    final public function getCancellationNotes(): ?string
    {
        return $this->cancellationNotes;
    }

    public function setCancellationNotes(?string $cancellationNotes): void
    {
        $this->cancellationNotes = $cancellationNotes;
    }

    /**
     * @return bool
     */
    public function getOnlyEditHead(): bool
    {
        return $this->onlyEditHead;
    }

    /**
     * @param bool $onlyEditHead  la cual se realiza en la pantalla de editar movimiento por transportista/operaciones
     */
    public function setOnlyEditHead(bool $onlyEditHead)
    {
        $this->onlyEditHead = $onlyEditHead;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        $vehicleLineArray = [];
        if (!empty($this->getVehicleLineCollection())) {
            /**
             * @var VehicleLine $vehicleLine
             */
            foreach ($this->getVehicleLineCollection() as $vehicleLine) {
                $vehicleLineArray[] = $vehicleLine->toArray();
            }
        }

        $vehicleFilterArray = [];
        if (!empty($this->getVehicleFilterCollection())) {
            /**
             * @var VehicleFilter $vehicleFilter
             */
            foreach ($this->getVehicleFilterCollection() as $vehicleFilter) {
                $vehicleFilterArray[] = $vehicleFilter->toArray();
            }
        }

        $deliveryNoteArray = [];
        if (!empty($this->getDeliveryNoteCollection())) {
            /**
             * @var DeliveryNote $deliveryNote
             */
            foreach ($this->getDeliveryNoteCollection() as $deliveryNote) {
                $deliveryNoteArray[] = $deliveryNote->toArray();
            }
        }

        return [
            'ID' => $this->getId(),
            'SAPPO' => $this->getOrderNumber(),
            'TRANSPORTTYPEID' => ($this->getMovementType()) ? $this->getMovementType()->getId() : null,
            'TRANSPORTCATID' => ($this->getMovementCategory()) ? $this->getMovementCategory()->getId() : null,
            'EXTTRANSPORT' => ($this->isExtTransport() !== null) ? ($this->isExtTransport() ? 1 : 0) : null,
            'TRANSPORTSTATUSID' => ($this->getMovementStatus()) ? $this->getMovementStatus()->getId() : null,
            'ORIGINLOCATIONID' => ($this->getOriginLocation()) ?
                $this->getOriginLocation()->getId()
                : ($this->getOriginExternalLocation() ?
                    $this->getOriginExternalLocation()->getId()
                    : null),
            'MANUALORIGINLOCATION' => ($this->getManualOriginLocation()) ? $this->getManualOriginLocation()->toArray(ManualLocation::ORIGIN) : null,
            'ORIGINBRANCHID' => ($this->getOriginBranch()) ? $this->getOriginBranch()->getId() : null,
            'DESTINYLOCATIONID' => ($this->getDestinationLocation()) ?
                $this->getDestinationLocation()->getId()
                : ($this->getDestinationExternalLocation() ?
                    $this->getDestinationExternalLocation()->getId()
                    : null),
            'MANUALDESTINATIONLOCATION' => ($this->getManualDestinationLocation()) ? $this->getManualDestinationLocation()->toArray(ManualLocation::DESTINATION) : null,
            // FIXME estos campos no se usan de momento en WS, quedan aquí para futuro refactor
            // 'DESTINATIONEXTERNALLOCATIONID' => $this->getDestinationExternalLocation() ? $this->getDestinationExternalLocation()->getId() : null,
            // 'DESTINATIONEXTERNALSUPPLIER' => $this->getDestinationExternalSupplier() ? $this->getDestinationExternalSupplier()->getId() : null,
            'DESTINYBRANCHID' => ($this->getDestinationBranch()) ? $this->getDestinationBranch()->getId() : null,
            'ESTIMATEDDEPARTURE' => ($this->getExpectedLoadDate()) ? Utils::formatDateToFirstMinuteDateTime($this->getExpectedLoadDate()->__toString()) : null,
            'ESTIMATEDARRIVAL' => ($this->getExpectedUnloadDate()) ? Utils::formatDateToLastMinuteDateTime($this->getExpectedUnloadDate()->__toString()) : null,
            'AUTHORIZATIONBYID' => ($this->getDepartment()) ? $this->getDepartment()->getId() : null,
            'TRANSPROVIDERID' => ($this->getSupplier()) ? $this->getSupplier()->getId() : null,
            'TRANSPORTDRIVERID' => ($this->getDriver()) ? $this->getDriver()->getId() : null,
            'BUSINESSUNITID' => ($this->getBusinessUnit()) ? $this->getBusinessUnit()->getId() : null,
            'TRANSSAPARTICLEID' => ($this->getBusinessUnitArticle()) ? $this->getBusinessUnitArticle()->getId() : null,
            'TRANSPORTMETHODID' => ($this->getTransportMethod()) ? $this->getTransportMethod()->getId() : null,
            'TRANSPORTUNITS' => $this->getVehicleUnits(),
            'EXTTRANSPORTCOST' => $this->getManualCost() ? $this->getManualCost()->getFloatValue() : null,
            'EXTTRANSPORTCOSTROUTE' => $this->getAutomaticCost() ? $this->getAutomaticCost()->getFloatValue() : null,
            'TRANSPORTOBS' => $this->getNotes(),
            'VEHICLELINEARRAY' => $vehicleLineArray,
            'VEHICLEFILTERARRAY' => $vehicleFilterArray,
            'DELIVERYNOTEARRAY' => $deliveryNoteArray,
            'NOTES' => $this->getClosingNotes() ?? $this->getCancellationNotes(),
            'ONLYHEAD' => $this->getOnlyEditHead() ? 1 : 0,
            'COSTCENTERNAME' => ConstantsJsonFile::getValue('COSTCENTER_LOGISTICS')
        ];
    }
}
