<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\EditStopSale;

class EditStopSaleQuery
{
    /**
     * @var int
     */
    private int $id;

    /**
     * EditStopSaleQuery constructor.
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
