<?php
declare(strict_types=1);


namespace Distribution\ParameterSettingType\Domain;


use Shared\Domain\GetByResponse;

class ParameterSettingTypeGetByResponse extends GetByResponse
{
    /**
     * ParameterSettingTypeGetByResponse constructor.
     * @param ParameterSettingTypeCollection $collection
     * @param int $totalRows
     */
    public function __construct(ParameterSettingTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}