<?php

namespace Distribution\LocationType\Application\SelectList;

class SelectListLocationTypeResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListLocationTypeResponse constructor.
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
