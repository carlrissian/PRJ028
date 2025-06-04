<?php
declare(strict_types=1);

namespace Distribution\CarClass\Domain;

interface CarClassRepository
{
    /**
     * @param CarClassCriteria $carClassCriteria
     * @return CarClassGetByResponse
     */
    public function getBy(CarClassCriteria $carClassCriteria): CarClassGetByResponse;

    /**
     * @param int $id
     * @return CarClass
     */
    public function getById(int $id): CarClass;

    /**
     * @param string $acrissLetter
     * @return CarClass
     */
    public function getByAcrissLetter(string $acrissLetter): CarClass;

    /**
     * @param int $id
     * @param bool $carClassStatus
     * @return CarClass
     */
    public function activate(int $id, bool $carClassStatus): ?CarClass;
}
