<?php

namespace Distribution\StopSale\Application\StoreStopSale;

final class StoreStopSaleResponse
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * StoreStopSaleResponse constructor.
     *
     * @param integer $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
