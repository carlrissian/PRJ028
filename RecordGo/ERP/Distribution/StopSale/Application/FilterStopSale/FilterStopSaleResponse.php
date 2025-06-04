<?php
declare(strict_types=1);


namespace Distribution\StopSale\Application\FilterStopSale;


class FilterStopSaleResponse
{
    /**
     * @var array
     */
    private array $stopSaleResponse;

    /**
     * FilterStopSaleResponse constructor.
     * @param array $stopSaleResponse
     */
    public function __construct(array $stopSaleResponse)
    {
        $this->stopSaleResponse = $stopSaleResponse;
    }

    /**
     * @return array
     */
    public function getStopSaleResponse(): array
    {
        return $this->stopSaleResponse;
    }

}