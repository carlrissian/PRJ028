<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\ListHistoryStopSale;

class ListHistoryStopSaleQuery
{
    /**
     * @var int
     */
    private int $stopSaleId;

    /**
     * ListHistoryStopSaleQuery constructor.
     * 
     * @param int $stopSaleId
     */
    public function __construct(int $stopSaleId)
    {
        $this->stopSaleId = $stopSaleId;
    }

    /**
     * @return int
     */
    public function getStopSaleId(): int
    {
        return $this->stopSaleId;
    }
}
