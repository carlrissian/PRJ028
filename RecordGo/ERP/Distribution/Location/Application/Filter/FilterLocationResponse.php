<?php

namespace Distribution\Location\Application\Filter;

class FilterLocationResponse
{
    /**
     * @var array
     */
    private $rows;

    /**
     * @var int
     */
    private $totalRows;

    /**
     * FilterLocationResponse constructor.
     *
     * @param array $rows
     * @param integer $totalRows
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
