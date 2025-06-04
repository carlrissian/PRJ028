<?php

declare(strict_types=1);


namespace Distribution\StopSale\Application\CancelStopSale;


class CancelStopSaleResponse
{
    /**
     * @var bool
     */
    private bool $cancelled;

    /**
     * CancelStopSaleResponse constructor.
     * 
     * @param bool $cancelled
     */
    public function __construct(bool $cancelled)
    {
        $this->cancelled = $cancelled;
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->cancelled;
    }
}
