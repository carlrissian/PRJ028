<?php

declare(strict_types=1);


namespace Distribution\Movement\Domain;


class AssignedLicensePlateUnits
{
    /**
     * @var int
     */
    private int $total;
    /**
     * @var int
     */
    private int $load;
    /**
     * @var int
     */
    private int $unload;

    /**
     * AssignedLicensePlateUnits constructor.
     * 
     * @param int $total
     * @param int $load
     * @param int $unload
     */
    public function __construct(int $total, int $load, int $unload)
    {
        $this->total = $total;
        $this->load = $load;
        $this->unload = $unload;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getLoad(): int
    {
        return $this->load;
    }

    /**
     * @return int
     */
    public function getUnload(): int
    {
        return $this->unload;
    }
}
