<?php

namespace Distribution\Damage\Application\FilterDamage;

class FilterDamageQuery
{
    /**
     * @var int|null
     */
    private $vehicleId;

    /**
     * @var string|null
     */
    private $vehiclePickupDate;

    /**
     * FilterDamageQuery constructor.
     *
     * @param int|null $vehicleId
     * @param string|null $vehiclePickupDate
     */
    public function __construct(
        ?int $vehicleId,
        ?string $vehiclePickupDate
    ) {
        $this->vehicleId = $vehicleId;
        $this->vehiclePickupDate = $vehiclePickupDate;
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
    public function getVehiclePickupDate(): ?string
    {
        return $this->vehiclePickupDate;
    }
}
