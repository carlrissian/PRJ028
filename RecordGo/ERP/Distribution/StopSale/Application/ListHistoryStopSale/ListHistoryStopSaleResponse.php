<?php
declare(strict_types=1);


namespace Distribution\StopSale\Application\ListHistoryStopSale;


class ListHistoryStopSaleResponse
{
    /**
     * @var array
     */
    private array $stopSaleHistoryResponse;

    /**
     * ListHistoryStopSaleResponse constructor.
     * @param array $stopSaleHistoryResponse
     */
    public function __construct(array $stopSaleHistoryResponse)
    {
        $this->stopSaleHistoryResponse = $stopSaleHistoryResponse;
    }

    /**
     * @return array
     */
    public function getStopSaleHistoryResponse(): array
    {
        return $this->stopSaleHistoryResponse;
    }


}