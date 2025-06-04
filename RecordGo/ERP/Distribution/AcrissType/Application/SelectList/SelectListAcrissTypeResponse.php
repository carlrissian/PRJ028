<?php

namespace Distribution\AcrissType\Application\SelectList;

class SelectListAcrissTypeResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListAcrissTypeResponse constructor.
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
