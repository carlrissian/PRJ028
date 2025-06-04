<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\UpdateStopSale;

class UpdateStopSaleResponse
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * UpdateStopSaleResponse constructor.
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
