<?php

namespace Distribution\State\Application\FilterState;

class FilterStateResponse
{
    /**
     * @var array
     */
    private $stateList;

    /**
     * FilterStateResponse constructor.
     * 
     * @param array $stateList
     */
    public function __construct(array $stateList)
    {
        $this->stateList = $stateList;
    }

    /**
     * @return array
     */
    public function getStateList(): array
    {
        return $this->stateList;
    }
}
