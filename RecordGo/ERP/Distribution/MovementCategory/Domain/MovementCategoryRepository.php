<?php
declare(strict_types=1);


namespace Distribution\MovementCategory\Domain;


interface MovementCategoryRepository
{
    /**
     * @param MovementCategoryCriteria $movementCategoryCriteria
     * @return MovementCategoryGetByResponse
     */
    public function getBy( MovementCategoryCriteria $movementCategoryCriteria):  MovementCategoryGetByResponse;
}