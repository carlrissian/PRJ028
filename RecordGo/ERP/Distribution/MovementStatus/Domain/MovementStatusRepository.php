<?php
declare(strict_types=1);


namespace Distribution\MovementStatus\Domain;


interface MovementStatusRepository
{
    /**
     * @param MovementStatusCriteria $movementStatusCriteria
     * @return MovementStatusGetByResponse
     */
    public function getBy( MovementStatusCriteria $movementStatusCriteria):  MovementStatusGetByResponse;
}