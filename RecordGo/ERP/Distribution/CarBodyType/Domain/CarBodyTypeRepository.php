<?php
declare(strict_types=1);


namespace Distribution\CarBodyType\Domain;


/**
 * Interface CarBodyTypeRepository
 * @package Distribution\CarBodyType\Domain
 */
interface CarBodyTypeRepository
{

    /**
     * @param CarBodyTypeCriteria $bodyworkCriteria
     * @return CarBodyTypeGetByResponse
     */
    public function getBy(CarBodyTypeCriteria $bodyworkCriteria): CarBodyTypeGetByResponse;
}