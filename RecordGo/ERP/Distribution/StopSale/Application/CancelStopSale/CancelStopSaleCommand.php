<?php
declare(strict_types=1);


namespace Distribution\StopSale\Application\CancelStopSale;


class CancelStopSaleCommand
{
    /**
     * @var int
     */
    private int $id;

    /**
     * CancelStopSaleCommand constructor.
     * @param int $id
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