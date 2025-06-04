<?php

namespace Distribution\TransportDriver\Domain;

interface TransportDriverRepository
{
    /**
     * @param TransportDriverCriteria $criteria
     * @return TransportDriverGetByResponse
     */
    public function getBy(TransportDriverCriteria $criteria): TransportDriverGetByResponse;

    /**
     * @param int $id
     * @return TransportDriver
     */
    public function getById(int $id): TransportDriver;

    /**
     * @param TransportDriver $transportDriver
     * @return int
     */
    public function store(TransportDriver $transportDriver): int;
}
