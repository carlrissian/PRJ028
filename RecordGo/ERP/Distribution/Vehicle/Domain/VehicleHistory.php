<?php

declare(strict_types=1);

namespace Distribution\Vehicle\Domain;

use Shared\Domain\User;
use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateTimeValueObject;

class VehicleHistory
{
    /**
     * @var string|null
     */
    private ?string $location;

    /**
     * @var string|null
     */
    private ?string $branch;

    /**
     * @var float|null
     */
    private ?float $kilometers;

    /**
     * @var string|null
     */
    private ?string $originStatus;

    /**
     * @var string|null
     */
    private ?string $endStatus;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $statusChangeDate;

    /**
     * @var User|null
     */
    private ?User $statusChangeUser;

    /**
     * VehicleHistory constructor.
     *
     * @param string|null $location
     * @param string|null $branch
     * @param float|null $kilometers
     * @param string|null $originStatus
     * @param string|null $endStatus
     * @param DateTimeValueObject|null $statusChangeDate
     * @param ?User $statusChangeUser
     */
    public function __construct(
        ?string $location,
        ?string $branch,
        ?float $kilometers,
        ?string $originStatus,
        ?string $endStatus,
        ?DateTimeValueObject $statusChangeDate,
        ?User $statusChangeUser
    ) {
        $this->location = $location;
        $this->branch = $branch;
        $this->kilometers = $kilometers;
        $this->originStatus = $originStatus;
        $this->endStatus = $endStatus;
        $this->statusChangeDate = $statusChangeDate;
        $this->statusChangeUser = $statusChangeUser;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @return string|null
     */
    public function getBranch(): ?string
    {
        return $this->branch;
    }

    /**
     * @return float|null
     */
    public function getKilometers(): ?float
    {
        return $this->kilometers;
    }

    /**
     * @return string|null
     */
    public function getOriginStatus(): ?string
    {
        return $this->originStatus;
    }

    /**
     * @return string|null
     */
    public function getEndStatus(): ?string
    {
        return $this->endStatus;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getStatusChangeDate(): ?DateTimeValueObject
    {
        return $this->statusChangeDate;
    }

    /**
     * @return User|null
     */
    public function getStatusChangeUser(): ?User
    {
        return $this->statusChangeUser;
    }


    /**
     * @param array|null $vehicleHistoryArray
     * @return self
     */
    public static function createFromArray(?array $vehicleHistoryArray): self
    {
        $vehicleHistoryArray = array_change_key_case($vehicleHistoryArray, CASE_UPPER);
        return new self(
            $vehicleHistoryArray['LOCATIONNAME'] ?? null,
            $vehicleHistoryArray['BRANCHINTNAME'] ?? null,
            isset($vehicleHistoryArray['VEHICLEKMS']) ? intval($vehicleHistoryArray['VEHICLEKMS']) : null,
            $vehicleHistoryArray['VEHICLEORIGINSTATUSNAME'] ?? null,
            $vehicleHistoryArray['VEHICLEENDSTATUSNAME'] ?? null,
            isset($vehicleHistoryArray['STATUSCHANGEDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleHistoryArray['STATUSCHANGEDATE'])) : null,
            isset($vehicleHistoryArray['STATUSCHANGEUSER']) ? User::createFromArray($vehicleHistoryArray['STATUSCHANGEUSER']) : null
        );
    }
}
