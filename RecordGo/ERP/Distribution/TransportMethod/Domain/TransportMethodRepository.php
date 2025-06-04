<?php
declare(strict_types=1);


namespace Distribution\TransportMethod\Domain;


interface TransportMethodRepository
{
    /**
     * @param TransportMethodCriteria $transportMethodCriteria
     * @return TransportMethodGetByResponse
     */
    public function getBy(TransportMethodCriteria $transportMethodCriteria): TransportMethodGetByResponse;
}