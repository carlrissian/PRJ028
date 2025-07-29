<?php

namespace Distribution\StopSale\Domain;

interface StopSaleRepository
{
    /**
     * @param StopSaleCriteria $criteria
     * @return StopSaleGetByResponse
     */
    public function getBy(StopSaleCriteria $criteria): StopSaleGetByResponse;

    /**
     * @param int $stopSaleId
     * @return StopSaleGetByResponse
     */
    public function getStopSaleHistoryById(int $stopSaleId): StopSaleGetByResponse;

    /**
     * @param int $id
     * @return StopSale|null
     */
    public function getById(int $id): ?StopSale;

    /**
     * @param StopSale $stopSale
     * @return int
     */
    public function store(StopSale $stopSale): int;

    /**
     * @param StopSale $stopSale
     * @return int
     */
    public function update(StopSale $stopSale): int;
}
