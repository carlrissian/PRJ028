<?php

declare(strict_types=1);

namespace Distribution\Movement\Application\UpdateDateVehicle;

class UpdateDateVehicleResponse
{
    /**
     * @var bool
     */
    private bool $updated;

    /**
     * UpdateDateVehicleResponse constructor.
     * 
     * @param bool $updated
     */
    public function __construct(bool $updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return bool
     */
    public function isUpdated(): bool
    {
        return $this->updated;
    }
}
