<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\CreateStopSale;

class CreateStopSaleQuery
{
    /**
     * @var int
     */
    private int $categoryId;

    /**
     * CreateStopSaleQuery constructor.
     * 
     * @param int $categoryId
     */
    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
