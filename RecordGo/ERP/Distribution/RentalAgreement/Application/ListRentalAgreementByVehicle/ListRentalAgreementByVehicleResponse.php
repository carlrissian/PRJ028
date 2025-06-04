<?php

namespace Distribution\RentalAgreement\Application\ListRentalAgreementByVehicle;

class ListRentalAgreementByVehicleResponse
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
     * ListRentalAgreementByVehicleResponse constructor.
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
