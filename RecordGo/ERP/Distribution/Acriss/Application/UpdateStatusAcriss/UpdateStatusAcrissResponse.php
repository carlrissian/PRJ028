<?php

declare(strict_types=1);

namespace Distribution\Acriss\Application\UpdateStatusAcriss;

class UpdateStatusAcrissResponse
{
    /**
     * @var bool
     */
    private $updated;

    /**
     * @var bool
     */
    private $onBooking;

    /**
     * UpdateStatusAcrissResponse constructor.
     *
     * @param boolean $updated
     * @param boolean $onBooking
     */
    public function __construct(bool $updated, bool $onBooking)
    {
        $this->updated = $updated;
        $this->onBooking = $onBooking;
    }

    /**
     * Get the value of updated
     *
     * @return bool
     */
    public function isUpdated(): bool
    {
        return $this->updated;
    }

    /**
     * Get the value of onBooking
     *
     * @return bool
     */
    public function isOnBooking(): bool
    {
        return $this->onBooking;
    }
}
