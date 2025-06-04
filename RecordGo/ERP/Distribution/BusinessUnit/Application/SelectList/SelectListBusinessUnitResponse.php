<?php

namespace Distribution\BusinessUnit\Application\SelectList;

class SelectListBusinessUnitResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListBusinessUnitResponse constructor.
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
