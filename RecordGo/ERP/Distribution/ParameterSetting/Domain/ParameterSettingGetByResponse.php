<?php
declare(strict_types=1);


namespace Distribution\ParameterSetting\Domain;


use Shared\Domain\GetByResponse;

class ParameterSettingGetByResponse extends GetByResponse
{
    /**
     * ParameterSettingGetByResponse constructor.
     * @param ParameterSettingCollection $collection
     * @param int $totalRows
     */
    public function __construct(ParameterSettingCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}