<?php

namespace Distribution\TransportDriver\Application\FilterTransportDriver;

class FilterTransportDriverResponse
{
    /**
     * @var array
     */
    private $transportDriverListResponse;

    public function __construct(array $transportDriverListResponse)
    {
        $this->transportDriverListResponse = $transportDriverListResponse;
    }

    /**
     * Get the value of transportDriverListResponse
     *
     * @return  array
     */
    public function getTransportDriverListResponse()
    {
        return $this->transportDriverListResponse;
    }
}