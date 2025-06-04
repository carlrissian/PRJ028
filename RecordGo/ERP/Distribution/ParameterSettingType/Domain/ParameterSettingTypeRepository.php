<?php
declare(strict_types=1);


namespace Distribution\ParameterSettingType\Domain;

use Doctrine\Common\Collections\Criteria;

interface ParameterSettingTypeRepository
{
    /**
     * @param Criteria $criteria
     * @return ParameterSettingTypeGetByResponse
     */
    public function getBy(Criteria $criteria): ParameterSettingTypeGetByResponse;
}