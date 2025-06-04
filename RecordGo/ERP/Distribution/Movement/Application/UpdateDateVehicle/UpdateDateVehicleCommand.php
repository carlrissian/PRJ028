<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\UpdateDateVehicle;

class UpdateDateVehicleCommand
{
    /**
     * @var int
     */
    private int $movementId;

    /**
     * @var array
     */
    private array $vehicleIdList;

    /**
     * @var string|null
     */
    private ?string $actualLoadDate;

    /**
     * @var string|null
     */
    private ?string $actualUnloadDate;

    /**
     * @param int $movementId
     * @param array $vehicleIdList
     * @param string|null $actualLoadDate
     * @param string|null $actualUnloadDate
     */
    public function __construct(
        int $movementId,
        array $vehicleIdList,
        ?string $actualLoadDate,
        ?string $actualUnloadDate
    ) {
        $this->movementId = $movementId;
        $this->vehicleIdList = $vehicleIdList;
        $this->actualLoadDate = $actualLoadDate;
        $this->actualUnloadDate = $actualUnloadDate;
    }

    /**
     * @return int
     */
    public function getMovementId(): int
    {
        return $this->movementId;
    }

    /**
     * @return array
     */
    public function getVehicleIdList(): array
    {
        return $this->vehicleIdList;
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
    public function getActualUnLoadDate(): ?string
    {
        return $this->actualUnloadDate;
    }
}
