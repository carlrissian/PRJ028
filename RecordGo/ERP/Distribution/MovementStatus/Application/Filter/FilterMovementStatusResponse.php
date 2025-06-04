<?php

namespace Distribution\MovementStatus\Application\Filter;

class FilterMovementStatusResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * FilterMovementStatusResponse constructor.
     *
     * @param array $selectList
     */
    public function __construct(array $selectList)
    {
        $this->selectList = $selectList;
    }

    /**
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
