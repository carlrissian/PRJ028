<?php
declare(strict_types=1);


namespace Distribution\LocationType\Domain;


interface LocationTypeRepository
{
    /**
     * @param LocationTypeCriteria $locationTypeCriteria
     * @return LocationTypeGetByResponse
     */
    public function getBy(LocationTypeCriteria $locationTypeCriteria): LocationTypeGetByResponse;

}