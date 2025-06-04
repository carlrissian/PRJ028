<?php

declare(strict_types=1);

namespace Distribution\StopSale\Application\CreateStopSale;

class CreateStopSaleResponse
{
    /**
     * @var array
     */
    private array $selectList;

    /**
     * CreateStopSaleResponse constructor.
     * 
     * @param array $selectList
     */
    public function __construct(array $selectList)
    {
        $this->selectList = $selectList;
    }

    /**
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
