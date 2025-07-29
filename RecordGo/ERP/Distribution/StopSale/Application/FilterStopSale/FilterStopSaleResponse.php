<?php

namespace Distribution\StopSale\Application\FilterStopSale;

final class FilterStopSaleResponse
{
    /**
     * @var array $rows
     */
    private $rows;

    /**
     * @var int $totalRows
     */
    private $totalRows;

    /**
     * FilterStopSaleResponse constructor.
     * 
     * @param array $rows
     * @param int $totalRows
     */
    public function __construct(array $rows, int $totalRows)
    {
        $this->rows = $rows;
        $this->totalRows = $totalRows;
    }

    /**
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @return int
     */
    public function getTotalRows(): int
    {
        return $this->totalRows;
    }
}
