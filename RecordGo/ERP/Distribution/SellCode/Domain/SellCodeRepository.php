<?php


namespace Distribution\SellCode\Domain;

interface SellCodeRepository
{
    /**
     * @param SellCodeCriteria $sellCodeCriteria
     * @return SellCodeGetByResponse
     */
    public function getBy(SellCodeCriteria $sellCodeCriteria): SellCodeGetByResponse;

    /**
     * @param int $id
     * @return SellCode
     */
    public function getById(int $id): SellCode;

    /**
     * @param SellCode $sellCode
     * @return int
     */
    // public function store(SellCode $sellCode): int;

    /**
     * @param SellCode $sellCode
     * @return int
     */
    // public function update(SellCode $sellCode): int;
}
