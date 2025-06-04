<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\ListStopSale;

class ListStopSaleQuery
{
    /**
     * @var int
     */
    private int $stopSaleCategoryId;

    /**
     * @param int $stopSaleCategoryId
     */
    public function __construct(int $stopSaleCategoryId)
    {
        $this->stopSaleCategoryId = $stopSaleCategoryId;
    }

    /**
     * @return int
     */
    public function getStopSaleCategoryId(): int
    {
        return $this->stopSaleCategoryId;
    }
}
