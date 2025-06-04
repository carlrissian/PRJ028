<?php
declare(strict_types=1);

namespace Distribution\GearBox\Domain;

interface GearBoxRepository
{

    /**
     * @param GearBoxCriteria $criteria
     * @return GearBoxGetByResponse
     */
    public function getBy(GearBoxCriteria $criteria): GearBoxGetByResponse;


    /***
     * @param int $id
     * @return GearBox
     */
    public function getById(int $id): GearBox;

}
