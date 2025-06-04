<?php
declare(strict_types=1);


namespace Distribution\Acriss\Application\FilterAssociateAcriss;


class FilterAssociateResponse
{
    /**
     * @var array
     */
    private array $acrissArray;
    /**
     * @var int
     */
    private int $totalRows;

    /**
     * @param array $acrissArray
     * @param int $totalRows
     */
    public function __construct(array $acrissArray, int $totalRows)
    {
        $this->acrissArray = $acrissArray;
        $this->totalRows = $totalRows;
    }

    /**
     * @return array
     */
    public function getAcrissArray(): array
    {
        return $this->acrissArray;
    }

    /**
     * @return int
     */
    public function getTotalRows(): int
    {
        return $this->totalRows;
    }


}